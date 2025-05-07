<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Student;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Services\ExamService;
use App\Services\StudentService;

class ExamController extends Controller
{
    public function __construct(
        private ?ExamService $examService = null,
        private ?StudentService $studentService = null
    ) {}

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
        $this->examService->submitAnswer($request);

        return redirect()->route('exam.question', ['index' => $request->current_index + 1]);
    }

    public function showQuestion($index)
    {
        $this->studentService->deactivate(session('student_id'));
    
        $questions = session('exam_questions', []);
        if (!isset($questions[$index])) {
            return redirect()->route('exam.results');
        }

        $question = Question::find($questions[$index]);

        $submittedAnswer = session('answered_questions', [])[$question->id]['selected'] ?? null;

        $correctAnswer = null;
        if ($submittedAnswer) {
            $correctAnswer = Answer::where([
                'question_id' => $question->id,
                'is_correct' => 1
            ])->pluck('id')->first();
        }

        return view('exam.question', [
            'test' => [
                'category' => session('test')['category']['name'],
                'option' => session('test')['option']['name'],
            ],
            'question' => $question,
            'index' => $index,
            'total' => count($questions),
            'answered' => session('answered_questions', []),
            'correctId' => $correctAnswer
        ]);
    }

    public function result()
    {
        $this->studentService->deactivate(session('student_id'));

        $this->examService->storeExam([
            'student_id' => session('student_id'),
            'category' => session('test')['category']['name'],
            'option' => session('test')['option']['name'],
            'questions' => session('exam_questions'),
            'correct_answers' => session('correct_answers'),
            'answered_questions' => session('answered_questions'),
        ]);

        $totalCorrect = count(session('correct_answers', []));
        return view('exam.result', compact('totalCorrect'));
    }
}
