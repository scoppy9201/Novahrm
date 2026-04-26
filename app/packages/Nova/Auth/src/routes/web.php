<?php

use Illuminate\Support\Facades\Route;
use Nova\Auth\Http\Controllers\LoginController;
use Nova\Auth\Http\Controllers\ForgotPasswordController;

Route::middleware(['web', 'guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('password.request');
    Route::post('/forgot-password/send-otp', [ForgotPasswordController::class, 'sendOtp'])->name('password.send-otp');
    Route::post('/forgot-password/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.verify-otp');
    Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'reset'])->name('password.reset');
});

Route::post('/logout', [LoginController::class, 'destroy'])->name('logout')->middleware(['web', 'auth']);