<?php

use Illuminate\Support\Facades\Route;
use App\packages\Nova\Core\src\Http\Controllers\DemoRegistrationController;

Route::get('/', function () {
    return view('core::home');
});

Route::post('/demo-register', [DemoRegistrationController::class, 'store'])->name('demo.register');