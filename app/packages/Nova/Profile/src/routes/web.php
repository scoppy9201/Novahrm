<?php

use Illuminate\Support\Facades\Route;
use App\packages\Nova\Profile\src\Http\Controllers\ProfileController;

Route::middleware(['web', 'auth'])->prefix('profile')->name('profile.')->group(function () {
    Route::get('/',          [ProfileController::class, 'index'])->name('index');
    Route::put('/',          [ProfileController::class, 'update'])->name('update');
    Route::put('/password',  [ProfileController::class, 'updatePassword'])->name('password');
    Route::post('/suspend',  [ProfileController::class, 'suspend'])->name('suspend'); 
    Route::delete('/',       [ProfileController::class, 'destroy'])->name('destroy');
    Route::put('/notifications', [ProfileController::class, 'updateNotifications'])->name('notifications');
});