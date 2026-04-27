<?php

use Illuminate\Support\Facades\Route;
use App\packages\Nova\Dashboard\src\Http\Controllers\DashboardController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});