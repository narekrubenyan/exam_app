<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\TestController;
use App\Http\Controllers\Dashboard\StudentController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\QuestionController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\TestResultController;
use App\Http\Controllers\Dashboard\SubcategoryController;


Route::prefix('dashboard')
->middleware( 'auth')
->group(function() {
    Route::get(uri: '/', action: [DashboardController::class, 'index'])->name(name: 'dashboard');

    Route::resource('questions', QuestionController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('subcategories', SubcategoryController::class);
    Route::resource('tests', TestController::class);
    Route::resource('students', StudentController::class);

    Route::get('testResults', [TestResultController::class, 'index'])->name('results.index');
    Route::get('testResults/{result}', [TestResultController::class, 'show'])->name('dashboard.results.show');
});

Route::get('/test', function () {
    return [
        'msg', 'done'
    ];
});
