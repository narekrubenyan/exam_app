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
            'category_id' => 'required',
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
            $student->test_id = $this->assignTest($request['category_id']);
            $student->save();
        }

        session(['student_id' => $student->id, 'test_id' => $student->test_id]);

        $test = Test::with('category', 'option')->find(session('test_id'));
        session(['test' => $test->toArray()]);

        $questions = $student->test->questions()->pluck('questions.id')->toArray();
        session([
            'exam_questions' => $questions,
            'current_index' => 0,
            'correct_answers' => []
        ]);

        return redirect()->route('exam.question', ['index' => 0]);
    }

    private function assignTest($categoryId)
    {
        $testIds = Test::where('category_id', $categoryId)->pluck('id')->toArray();

        $testCounts = Student::select('test_id')
            ->whereNotNull('test_id')
            ->where('test_id', 'in', $testIds)
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
        return redirect('/');
    }
}
