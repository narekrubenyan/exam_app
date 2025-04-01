<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\StudentAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes(options: [
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::get('/', [StudentAuthController::class, 'showLoginForm']);
Route::post('/student/login', [StudentAuthController::class, 'login']);
Route::post('/student/logout', [StudentAuthController::class, 'logout'])->name('student.logout');

Route::middleware('student.auth')->group(function () {
    Route::get('/exam', [ExamController::class, 'start'])->name('exam.start');
    Route::get('/exam/question/{index}', [ExamController::class, 'showQuestion'])->name('exam.question');
    Route::post('/exam/submit', [ExamController::class, 'submitAnswer'])->name('exam.submit');
    Route::get('/exam/result', [ExamController::class, 'result'])->name('exam.results');
});
