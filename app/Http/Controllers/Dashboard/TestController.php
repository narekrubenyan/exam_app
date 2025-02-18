<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Test;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::all();

        return view('dashboard.tests.index', compact('tests'));
    }
}
