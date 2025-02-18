<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Test;
use Illuminate\Http\Request;
use App\Services\TestService;
use App\Http\Controllers\Controller;

class TestController extends Controller
{

    public function __construct(
        private ?TestService $testService = null
    ) {}

    public function index()
    {
        $tests = Test::all();

        return view('dashboard.tests.index', compact('tests'));
    }

    public function generate()
    {
        $this->testService->generate();

        return redirect()->route('tests.index');
    }
}
