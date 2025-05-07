<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\TestResult;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $results = TestResult::with(['student', 'answers'])->latest()->paginate(15);
        
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
