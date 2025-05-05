<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Student;
use App\Models\Question;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function start()
    {
        $student = Student::find(session('student_id'));

        if (!$student) {
            return redirect()->route('student.login')->withErrors(['error' => 'Please log in first']);
        }

        if (!session()->has('exam_questions')) {
            $questions = $student->test->questions()->pluck('id')->toArray();
            session([
                'exam_questions' => $questions,
                'current_index' => 0,
                'correct_answers' => []
            ]);
        }

        return redirect()->route('exam.question', ['index' => 0]);
    }

    public function submitAnswer(Request $request)
    {
        $student = Student::find(session('student_id'));
        $questionId = $request->question_id;
        $selectedAnswer = $request->answer;

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

        return redirect()->route('exam.question', ['index' => $request->current_index + 1]);
    }

    public function showQuestion($index)
    {
        $questions = session('exam_questions', []);
        if (!isset($questions[$index])) {
            return redirect()->route('exam.results');
        }

        $question = Question::find($questions[$index]);

        return view('exam.question', [
            'test' => [
                'category' => session('test')['category']['name'],
                'option' => session('test')['option']['name'],
            ],
            'question' => $question,
            'index' => $index,
            'total' => count($questions),
            'answered' => session('answered_questions', []),
        ]);
    }

    public function result()
    {
        $totalCorrect = count(session('correct_answers', []));
        return view('exam.result', compact('totalCorrect'));
    }
}
