<?php

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
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
});

Route::get('/test', function () {
    return [
        'msg', 'done'
    ];
});
