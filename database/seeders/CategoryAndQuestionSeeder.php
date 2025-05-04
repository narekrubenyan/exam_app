<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Database\Seeder;

class CategoryAndQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = Category::factory()->count(10)->create();
    
        $categories->each(function ($category) {
            Question::factory()
                ->count(rand(3, 7))
                ->create(['category_id' => $category->id])
                ->each(function ($question) {
                    // Create 4 incorrect answers
                    $incorrectAnswers = Answer::factory()->count(4)->make([
                        'question_id' => $question->id,
                        'is_correct' => false,
                    ]);
    
                    // Create 1 correct answer
                    $correctAnswer = Answer::factory()->make([
                        'question_id' => $question->id,
                        'is_correct' => true,
                    ]);
    
                    // Combine and shuffle
                    $allAnswers = $incorrectAnswers->push($correctAnswer)->shuffle();
    
                    // Save all
                    $question->answers()->saveMany($allAnswers);
                });
        });
    }
}
