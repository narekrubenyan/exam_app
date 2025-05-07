<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\Student;
use App\Models\Question;
use App\Models\TestResult;
use App\Models\TestResultAnswer;
use Illuminate\Support\Facades\DB;

/**
 * Class ExamService.
 */
class ExamService
{
    public function submitAnswer($data)
    {
        $student = Student::find(session('student_id'));
        $questionId = $data->question_id;
        $selectedAnswer = $data->answer;

        $question = Question::with('answers')->find($questionId);

        if (!in_array($selectedAnswer, $question->answers->pluck('id')->toArray())) {
            return redirect()
                ->back()
                ->withErrors(['name' => __('messages.tests.questionCountMinError', [
                    'category' => $category->name
                ])])
                ->withInput();
        }

        $isCorrect = Answer::find($selectedAnswer)->is_correct;
        $answeredQuestions = session('answered_questions', []);

        if ($isCorrect && !isset($answeredQuestions[$questionId])) {
            session()->push('correct_answers', $questionId);
        }

        $answeredQuestions[$questionId] = [
            'selected' => $selectedAnswer,
            'correct' => $isCorrect,
        ];
        session(['answered_questions' => $answeredQuestions]);
    }

    public function storeExam(array $data)
    {
        DB::transaction(function () use ($data) {
            $score = count($data['correct_answers']);

            $testResult = TestResult::create([
                'student_id' => $data['student_id'],
                'category' => $data['category'],
                'option' => $data['option'],
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
