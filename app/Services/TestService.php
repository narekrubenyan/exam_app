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
        return DB::transaction(function () use ($data) {

            $categoryId = $data['category_id'];
            $requiredTotal = $data['count'];
            $time = $data['time'];

            // 1️⃣ Get all subcategories for this category
            $subcategories = Subcategory::where('category_id', $categoryId)->pluck('id');

            // 2️⃣ Get all available questions
            $questions = Question::whereIn('subcategory_id', $subcategories)->get();

            if ($questions->count() < $requiredTotal * 4) { // 4 options
                throw new \Exception(__('validation.custom.questions.min-count'));
            }

            // 3️⃣ Calculate per-subcategory distribution
            $subcategoryCount = $subcategories->count();
            $perSubcategory = intdiv($requiredTotal, $subcategoryCount);
            $remainder = $requiredTotal % $subcategoryCount;

            $distribution = [];
            foreach ($subcategories as $subId) {
                $distribution[$subId] = $perSubcategory;
                if ($remainder > 0) {
                    $distribution[$subId]++;
                    $remainder--;
                }
            }

            // 4️⃣ Loop through 4 fixed options
            foreach (Option::all() as $option) {

                $selectedQuestions = collect();

                // Pick random questions per subcategory
                foreach ($distribution as $subId => $count) {
                    $subQuestions = Question::where('subcategory_id', $subId)
                        ->inRandomOrder()
                        ->take($count)
                        ->get();

                    $selectedQuestions = $selectedQuestions->merge($subQuestions);
                }

                $selectedIds = $selectedQuestions->pluck('id')->unique();

                if ($selectedIds->count() < $requiredTotal) {
                    throw new \Exception("Недостаточно вопросов для варианта {$option->name}");
                }

                // 5️⃣ Create or update test
                $test = Test::updateOrCreate(
                    ['option_id' => $option->id, 'category_id' => $categoryId],
                    ['time' => $time]
                );

                // 6️⃣ Attach questions
                $test->questions()->sync($selectedIds);
            }

            return redirect()
                ->route('tests.index')
                ->with('success', __('messages.variants_created'));
        });
    }
}
