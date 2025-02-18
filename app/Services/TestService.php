<?php

namespace App\Services;

use App\Models\Test;
use App\Models\Question;
use App\Models\TestQuestions;

/**
 * Class TestService.
 */
class TestService
{
    public function generate()
    {
        TestQuestions::truncate();

        $testIds = Test::pluck('id');

        foreach ($testIds as $tId) {
            $randomQuestionIds = Question::inRandomOrder()->pluck('id')->take(20);

            foreach ($randomQuestionIds as $qId) {
                TestQuestions::create([
                    'test_id' => $tId,
                    'question_id' => $qId
                ]);
            }
        }
    }
}
