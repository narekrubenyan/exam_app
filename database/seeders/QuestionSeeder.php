<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::factory()->count(10)->create();

        $categories->each(function ($category) {
            Question::factory()
                ->count(rand(3, 7))
                ->create(['category_id' => $category->id])
                ->each(function ($question) {
                    $incorrectAnswers = Answer::factory()->count(4)->make([
                        'is_correct' => false,
                    ]);
        
                    $correctAnswer = Answer::factory()->make([
                        'is_correct' => true,
                    ]);
        
                    $allAnswers = $incorrectAnswers->push($correctAnswer)->shuffle();        
                    $question->answers()->saveMany($allAnswers);
                });
        });
    }
}
