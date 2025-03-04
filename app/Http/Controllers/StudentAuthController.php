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

        // Assign a test if the student doesn't already have one
        if (!$student->test_id) {
            $student->test_id = $this->assignTest();
            $student->save();
        }

        session([
            'student_id' => $student->id,
            'test_id' => $student->test_id,
            'student_naem' => $student->name
        ]);

        return redirect()->route('exam.start');
    }

    // Function to assign tests equally
    private function assignTest()
    {
        // Get all test IDs
        $testIds = Test::pluck('id')->toArray();

        // Count how many students have each test assigned
        $testCounts = Student::select('test_id')
            ->whereNotNull('test_id')
            ->groupBy('test_id')
            ->selectRaw('test_id, COUNT(*) as count')
            ->pluck('count', 'test_id');

        // Find the test with the least students assigned
        $minTest = $testIds[0]; // Default to first test
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
