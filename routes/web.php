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

Route::get('/student/login', [StudentAuthController::class, 'showLoginForm']);
Route::post('/student/login', [StudentAuthController::class, 'login']);
Route::post('/student/logout', [StudentAuthController::class, 'logout'])->name('student.logout');

Route::get('/exam/start', [ExamController::class, 'start'])
    ->name('exam.start')
    ->middleware('student.auth');
