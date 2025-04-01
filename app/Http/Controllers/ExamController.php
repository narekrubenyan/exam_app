<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Student;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function start()
    {
        $student = Student::find(session('student_id'));

        if (!$student) {
            return redirect()->route('student.login')->withErrors(['error' => 'Please log in first']);
        }

        // Ensure exam questions are stored in session
        if (!session()->has('exam_questions')) {
            $questions = $student->test->questions()->pluck('id')->toArray();
            session([
                'exam_questions' => $questions,
                'current_index' => 0,
                'correct_answers' => 0
            ]);
        }

        // Redirect to first question
        return redirect()->route('exam.question', ['index' => 0]);
    }

    public function submitAnswer(Request $request)
    {
        $student = Student::find(session('student_id'));
        $questionId = $request->question_id;
        $selectedAnswer = $request->answer;

        // Get the question and correct answer(s)
        $question = Question::find($questionId);
        $correctAnswers = explode(',', $question->correct_answers); // If stored as "1,2,3"

        // Check if answer is correct
        $isCorrect = in_array($selectedAnswer, $correctAnswers);

        // Store answer in session (prevent changes)
        $answeredQuestions = session('answered_questions', []);
        $answeredQuestions[$questionId] = [
            'selected' => $selectedAnswer,
            'correct' => $isCorrect,
        ];
        session(['answered_questions' => $answeredQuestions]);

        // Update total correct count
        $correctCount = session('correct_answers', 0);
        if ($isCorrect && !isset($answeredQuestions[$questionId])) {
            session(['correct_answers' => $correctCount + 1]);
        }

        // Move to next question
        return redirect()->route('exam.question', ['index' => $request->current_index + 1]);
    }

    public function showQuestion($index)
    {
        $questions = session('exam_questions', []);
        if (!isset($questions[$index])) {
            return redirect()->route('exam.results'); // Redirect if out of range
        }

        $question = Question::find($questions[$index]);

        return view('exam.question', [
            'question' => $question,
            'index' => $index,
            'total' => count($questions),
            'answered' => session('answered_questions', []),
        ]);
    }

    public function result()
    {
        $totalCorrect = session('correct_answers', 0);
        return view('exam.result', compact('totalCorrect'));
    }
}
