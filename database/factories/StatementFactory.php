<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Statement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Statement>
 */
class StatementFactory extends Factory
{
    /**
     * model
     *
     * @var undefined
     */
    protected $model = Statement::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text' => $this->faker->sentence(),
            'question_id' => Question::factory(),
        ];
    }
}
