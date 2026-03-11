<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Student;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StudentAuthController extends Controller
{
    public function showLoginForm()
    {
        $categories = Category::select('id', 'name')->get();

        return view('auth.student-login', compact('categories'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'login_code' => 'required',
        ]);

        $student = Student::where([
            'name' => $request->name,
            'surname' => $request->surname,
            'login_code' => $request->login_code
        ])->first();

        if (!$student) {
            return back()->withErrors(['error' => __('messages.student.not_found')]);
        }

        if (!$student->test_id) {
            $testId = $this->assignTest();

            if (!$testId) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => __('exam.testNotExist')])
                    ->withInput();
            }

            $student->test_id = $testId;
            $student->save();
        }

        session([
            'student_id' => $student->id,
            'test_id' => $student->test_id
        ]);

        $test = Test::with('category', 'option')->find(session('test_id'));
        session([
            'test' => $test->toArray(),
            'exam_start_time' => now(),
            'exam_end_time' => now()->addMinutes($test->time)
        ]);

        $questions = $student->test
            ->questions()
            ->pluck('questions.id')
            ->toArray();

        session([
            'exam_questions' => $questions,
            'current_index' => 0,
            'correct_answers' => []
        ]);

        return redirect()->route('exam.question', ['index' => 0]);
    }

    private function assignTest()
    {
        $tests = Test::pluck('id')->toArray();

        if (!$tests) {
            return false;
        }

        $counts = Student::whereNotNull('test_id')
            ->selectRaw('test_id, COUNT(*) as total')
            ->groupBy('test_id')
            ->pluck('total', 'test_id')
            ->toArray();

        $selectedTest = null;
        $minCount = PHP_INT_MAX;

        foreach ($tests as $testId) {
            $count = $counts[$testId] ?? 0;

            if ($count < $minCount) {
                $minCount = $count;
                $selectedTest = $testId;
            }
        }

        return $selectedTest;
    }

    public function logout()
    {
        Session::flush();
        return redirect('/');
    }
}
