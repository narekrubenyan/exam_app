<?php

namespace App\Services;

use App\Models\Test;
use App\Models\Option;
use App\Models\Category;
use App\Models\Question;
use App\Models\TestQuestions;
use Illuminate\Support\Facades\DB;

/**
 * Class TestService.
 */
class TestService
{
    public function createOrUpdate($categoryId)
    {
        DB::beginTransaction();
        try {
            $category = Category::findOrFail($categoryId);
            $options = Option::all();
            
            $options->each(function ($option) use ($category) {
                $questions = Question::where('category_id', $category->id)
                    ->inRandomOrder()
                    ->take(20)
                    ->get();
    
                if ($questions->count() < 20) {
                    return redirect()->route('tests.create', [
                        'error' => 'Not enough questions in this category'
                    ]);
                }

                $test = Test::where('category_id', $category->id)
                    ->where('option_id', $option->id)
                    ->first();
    
                if ($test) {
                    $test->questions()->sync($questions->pluck('id'));
                } else {
                    $test = Test::create([
                        'category_id' => $category->id,
                        'option_id' => $option->id
                    ]);

                    $test->questions()->attach($questions->pluck('id'));
                }
            });
            DB::commit();

            return true;
        } catch (\Exeption $e) {
            DB::rollback();
            report($e);

            return redirect()->route('tests.create', [
                'error' => $e->getMessage
            ]);
        }
    }
}
