<?php

namespace App\Services;

use App\Models\Test;
use App\Models\Option;
use App\Models\Category;
use App\Models\Question;
use App\Models\Subcategory;
use Illuminate\Support\Facades\DB;

/**
 * Class TestService.
 */
class TestService
{
    public function createOrUpdate($data)
    {
        DB::beginTransaction();

        try {
            $categoryIds = $data['categories'];
            $requiredTotal = $data['count'];

            $categories = Category::whereIn('id', $categoryIds)->get();
            $options = Option::all();

            $subcategories = Subcategory::whereIn('category_id', $categoryIds)->pluck('id');

            $totalAvailable = Question::whereIn('subcategory_id', $subcategories)->count();

            if ($totalAvailable < $requiredTotal) {
                DB::rollBack();
                return back()
                    ->withErrors(['name' => 'Недостаточно вопросов в выбранных категориях'])
                    ->withInput();
            }

            $categoryCount = count($categoryIds);
            $perCategory = intdiv($requiredTotal, $categoryCount);
            $remainder = $requiredTotal % $categoryCount;

            $distribution = [];
            foreach ($categoryIds as $catId) {
                $distribution[$catId] = $perCategory;

                if ($remainder > 0) {
                    $distribution[$catId]++;
                    $remainder--;
                }
            }

            foreach ($options as $option) {

                $selectedQuestions = collect();

                foreach ($distribution as $catId => $count) {
                    $subcatIds = Subcategory::where('category_id', $catId)->pluck('id');

                    $questions = Question::whereIn('subcategory_id', $subcatIds)
                        ->inRandomOrder()
                        ->take($count)
                        ->get();

                    $selectedQuestions = $selectedQuestions->merge($questions);
                }

                $selectedIds = $selectedQuestions->pluck('id')->unique();

                if ($selectedIds->count() < $requiredTotal) {
                    DB::rollBack();
                    throw new \Exception("Недостаточно вопросов для варианта {$option->id}");
                }

                $test = Test::where('option_id', $option->id)->first();

                if (!$test) {
                    $test = Test::create([
                        'option_id' => $option->id,
                    ]);
                }

                $test->questions()->sync($selectedIds);
            }

            DB::commit();

            return redirect()->route('tests.index')->with('success', __('messages.variants_created'));
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);

            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

}
