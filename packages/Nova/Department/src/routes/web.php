<?php

use Illuminate\Support\Facades\Route;
use Nova\Department\Http\Controllers\DepartmentController;
use Nova\Department\Http\Controllers\PositionController;

Route::middleware(['web', 'auth'])->prefix('hr')->name('hr.')->group(function () {
    Route::get('departments/search-managers', [DepartmentController::class, 'searchManagers'])
        ->name('departments.search-managers');  

    Route::resource('departments', DepartmentController::class);
    Route::resource('positions', PositionController::class);
});