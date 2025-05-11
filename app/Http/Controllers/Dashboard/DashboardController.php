<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Student;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(): View
    {
        $questionsCount = Question::query()->count();
        $categoriesCount = Category::query()->count();
        $studentsQount = Student::query()->count();

        return view('dashboard.index', compact(
            'questionsCount',
            'categoriesCount',
            'studentsQount',
        ));
    }
}
