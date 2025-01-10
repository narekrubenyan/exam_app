<?php

use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get(uri: '/', action: [DashboardController::class, 'index'])->name(name: 'dashboard');

