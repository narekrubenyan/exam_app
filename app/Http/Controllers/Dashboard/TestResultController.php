<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Filters\StudentFilter;
use App\Http\Requests\Student\FilterStudentRequest;
use App\Models\Student;
use App\Models\TestResult;
use App\Http\Controllers\Controller;

class TestResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FilterStudentRequest $request)
    {
        $data = $request->validated();

        $filter = app()->make(StudentFilter::class, ['queryParams' => array_filter($data)]);

        $studentIds = Student::filter($filter)
            ->latest()
            ->paginate(30)
            ->pluck('id')
            ->toArray();

        $results = TestResult::whereIn('student_id', $studentIds)
            ->with(['student', 'answers'])
            ->latest()
            ->paginate(15);

        return view('dashboard.results.index', compact('results'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = TestResult::with(['student', 'answers'])->find($id);

        return view('dashboard.results.show', compact('result'));
    }
}
