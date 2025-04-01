<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StudentAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.student-login');
    }

    public function login(Request $request)
    {
        $student = Student::where([
            'name' => $request->name,
            'surname' => $request->surname,
            'group' => $request->group,
        ])->first();

        if (!$student) {
            return back()->withErrors(['error' => __('messages.student.not_found')]);
        }

        if (!$student->test_id) {
            $student->test_id = $this->assignTest();
            $student->save();
        }

        session(['student_id' => $student->id, 'test_id' => $student->test_id]);

        $questions = $student->test->questions()->pluck('questions.id')->toArray();
        session([
            'exam_questions' => $questions,
            'current_index' => 0,
            'correct_answers' => 0
        ]);

        return redirect()->route('exam.question', ['index' => 0]);
    }

    private function assignTest()
    {
        $testIds = Test::pluck('id')->toArray();

        $testCounts = Student::select('test_id')
            ->whereNotNull('test_id')
            ->groupBy('test_id')
            ->selectRaw('test_id, COUNT(*) as count')
            ->pluck('count', 'test_id');

        $minTest = $testIds[0];
        $minCount = $testCounts[$minTest] ?? 0;

        foreach ($testIds as $testId) {
            if (($testCounts[$testId] ?? 0) < $minCount) {
                $minTest = $testId;
                $minCount = $testCounts[$testId] ?? 0;
            }
        }

        return $minTest;
    }

    public function logout()
    {
        Session::flush();
        return redirect('/student/login');
    }
}
