<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Test;
use App\Models\Category;
use App\Services\TestService;
use App\Http\Requests\TestRequest;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function __construct(
        private ?TestService $testService = null
    ) {}

    public function index()
    {
        $tests = Test::orderBy('id', 'desc')->paginate(30);

        return view('dashboard.tests.index', compact('tests'));
    }

    public function show(string $id)
    {
        $test = Test::with('questions.subcategory')->find($id);

        return view('dashboard.tests.show', compact('test'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('dashboard.tests.create', compact('categories'));
    }

    public function store(TestRequest $request)
    {
        $data = $request->validated();

        $this->testService->createOrUpdate($data);

        return redirect()->route('tests.index');
    }
}
