<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Filters\StudentFilter;
use App\Http\Requests\Student\FilterStudentRequest;
use App\Http\Requests\Student\StoreStudentRequest;
use App\Models\Student;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FilterStudentRequest $request)
    {
        $data = $request->validated();

        $filter = app()->make(StudentFilter::class, ['queryParams' => array_filter($data)]);

        $students = Student::filter($filter)->latest()->paginate(30);

        return view('dashboard.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        $data = $request->validated();

        Student::create($data);

        return redirect()->route('students.index')->with('success', __('messages.student.added'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Student::findOrFail($id);

        return view('dashboard.students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreStudentRequest $request, string $id)
    {
        $data = $request->validated();

        $student = Student::findOrFail($id);
        $student->update($data);

        return redirect()->route('students.index')->with('success', __('messages.student.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Student::destroy($id);

        return redirect()->route('students.index')->with('success', __('messages.student.deleted'));
    }
}
