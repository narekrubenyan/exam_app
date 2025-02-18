<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Statement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * model
     *
     * @var undefined
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
        ];
    }

    public function withRelations()
    {
        return $this->afterCreating(function (Question $question) {
            Statement::factory(5)->create(['question_id' => $question->id]); // Create 5 comments
            Answer::factory(5)->create(['question_id' => $question->id]); // Create 5 tags
        });
    }
}
