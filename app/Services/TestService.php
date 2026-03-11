<?php

namespace App\Services;

use App\Models\Test;
use App\Models\Option;
use App\Models\Question;
use App\Models\Subcategory;
use Illuminate\Support\Facades\DB;

class TestService
{
    public function createOrUpdate(array $data)
    {
        DB::transaction(function () use ($data) {

            Test::query()->delete();

            $categoryId = $data['category_id'];
            $requiredTotal = $data['count'];
            $time = $data['time'];

            $subcategories = Subcategory::where('category_id', $categoryId)->pluck('id');

            $subcategoryCount = $subcategories->count();
            $perSubcategory = intdiv($requiredTotal, $subcategoryCount);
            $remainder = $requiredTotal % $subcategoryCount;

            $distribution = [];
            foreach ($subcategories as $subId) {
                $distribution[$subId] = $perSubcategory + ($remainder > 0 ? 1 : 0);
                if ($remainder > 0) $remainder--;
            }

            foreach (Option::all() as $option) {
                $selectedIds = collect();

                foreach ($distribution as $subId => $count) {
                    $subQuestions = Question::where('subcategory_id', $subId)
                        ->inRandomOrder()
                        ->take($count)
                        ->pluck('id'); // Just get IDs, much faster than get()

                    $selectedIds = $selectedIds->merge($subQuestions);
                }

                if ($selectedIds->count() < $requiredTotal) {
                    throw new \Exception("Недостаточно вопросов для варианта {$option->name}");
                }

                $test = Test::create([
                    'option_id' => $option->id,
                    'category_id' => $categoryId,
                    'time' => $time
                ]);

                $test->questions()->sync($selectedIds);
            }
        });

        return redirect()
            ->route('tests.index')
            ->with('success', __('messages.variants_created'));
    }
}
