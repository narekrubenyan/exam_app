<?php

namespace App\Services;

use App\Models\Question;
use App\Models\TestResult;
use App\Models\TestResultAnswer;
use Illuminate\Support\Facades\DB;

/**
 * Class ExamService.
 */
class ExamService
{
    public function storeExam(array $data)
    {
        DB::transaction(function () use ($data) {
            $score = count($data['correct_answers']);
        
            $testResult = TestResult::create([
                'student_id' => $data['student_id'],
                'score' => $score,
            ]);

            $questions = Question::whereIn('id', $data['questions'])->get();
        
            foreach ($questions as $question) {
                
                $correctAnswer = $question->answers()->where('is_correct', true)->first()->text;

                $selected = $question->answers()
                    ->where('id', $data['answered_questions'][$question->id]['selected'])
                    ->first()->text;

                $isCorrect = $data['answered_questions'][$question->id]['correct'];

                TestResultAnswer::create([
                    'test_result_id' => $testResult->id,
                    'question_title' => $question->title,
                    'statements' => $question->statements,
                    'possible_answers' => $question->answers->pluck('text')->toArray(),                    
                    'correct_answer' => $correctAnswer ?? 'UNKNOWN',
                    'selected_answer' => $selected ?? 'UNKNOWN',
                    'is_correct' => $isCorrect,
                ]);
            }
        });
    }
}
