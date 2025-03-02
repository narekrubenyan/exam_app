<?php

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\TestController;
use App\Http\Controllers\Dashboard\StudentController;
use App\Http\Controllers\Dashboard\QuestionController;
use App\Http\Controllers\Dashboard\DashboardController;


Route::get(uri: '/', action: function (): RedirectResponse {
    return redirect()->route(route: 'dashboard');
});


Route::prefix('dashboard')
->middleware( 'auth')
->group(function() {

    Route::get(uri: '/', action: [DashboardController::class, 'index'])->name(name: 'dashboard');

    Route::resource('questions', QuestionController::class);
    Route::resource('tests', TestController::class);
    Route::resource('students', StudentController::class);

    Route::post('tests/generate', [TestController::class, 'generate'])->name('tests.generate');

});

Route::get('/test', function () {
    return [
        'msg', 'done'
    ];
});
