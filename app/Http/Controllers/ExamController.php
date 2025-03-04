<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Student;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function start(Request $request)
    {
        $student = Student::find(session('student_id'));
        $questions = $student->test->questions()->get();

        session([
            'exam_questions' => $questions->pluck('id')->toArray(),
            'current_index' => 0,
            'correct_answers' => 0
        ]);

        return redirect()->route('exam.question');
    }

    public function question()
    {
        $questions = session('exam_questions', []);
        $index = session('current_index', 0);

        if ($index >= count($questions)) {
            return redirect()->route('exam.result');
        }

        $question = Question::with(['statements', 'answers'])->find($questions[$index]);

        return view('exam.question', compact('question', 'index'));
    }

    public function submit(Request $request)
    {
        $questions = session('exam_questions', []);
        $index = session('current_index', 0);

        if ($index >= count($questions)) {
            return redirect()->route('exam.result');
        }

        $question = Question::find($questions[$index]);

        $selectedAnswer = $request->input('selected_answer');
        $correctAnswers = $question->answers()->where('is_right', true)->pluck('id')->toArray();

        if (in_array($selectedAnswer, $correctAnswers)) {
            session(['correct_answers' => session('correct_answers', 0) + 1]);
        }

        session(['current_index' => $index + 1]);

        if ($index + 1 >= count($questions)) {
            return redirect()->route('exam.result');
        }

        return redirect()->route('exam.question');
    }

    public function result()
    {
        $totalCorrect = session('correct_answers', 0);
        return view('exam.result', compact('totalCorrect'));
    }
}
