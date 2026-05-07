<?php

use Illuminate\Support\Facades\Route;
use Nova\Auth\Http\Controllers\LoginController;
use Nova\Auth\Http\Controllers\ForgotPasswordController;
use Nova\Auth\Http\Controllers\NovaIdController;

Route::middleware(['web', 'guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('password.request');
    Route::post('/forgot-password/send-otp', [ForgotPasswordController::class, 'sendOtp'])->name('password.send-otp');
    Route::post('/forgot-password/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.verify-otp');
    Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'reset'])->name('password.reset');

    // Nova ID (passwordless) 
    Route::prefix('nova-id')->name('nova-id.')->group(function () {
        Route::post('send',       [NovaIdController::class, 'send'])          ->name('send')       ->middleware('throttle:nova-id-send');
        Route::post('verify-otp', [NovaIdController::class, 'verifyOtp'])     ->name('verify-otp') ->middleware('throttle:nova-id-otp');
    });
});

// Magic link verify — không cần guest (link mở trên trình duyệt bất kỳ)
Route::get('/nova-id/verify', [NovaIdController::class, 'verifyMagicLink'])
    ->name('nova-id.verify')
    ->middleware('web');

Route::post('/logout', [LoginController::class, 'destroy'])->name('logout')->middleware(['web', 'auth']);