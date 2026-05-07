<?php

use Nova\document\Http\Controllers\DocumentApprovalController;
use Nova\document\Http\Controllers\DocumentCategoryController;
use Nova\document\Http\Controllers\DocumentController;
use Nova\document\Http\Controllers\DocumentSignatureController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {

    // Categories 
    Route::prefix('document-categories')->name('document-categories.')->group(function () {
        Route::get('/',                          [DocumentCategoryController::class, 'index'])        ->name('index');
        Route::get('/{category}',                [DocumentCategoryController::class, 'show'])         ->name('show');

        Route::middleware('role:hr|admin')->group(function () {
            Route::get('/create',                [DocumentCategoryController::class, 'create'])       ->name('create');
            Route::post('/',                     [DocumentCategoryController::class, 'store'])        ->name('store');
            Route::get('/{category}/edit',       [DocumentCategoryController::class, 'edit'])         ->name('edit');
            Route::put('/{category}',            [DocumentCategoryController::class, 'update'])       ->name('update');
            Route::delete('/{category}',         [DocumentCategoryController::class, 'destroy'])      ->name('destroy');
            Route::patch('/{category}/toggle-active', [DocumentCategoryController::class, 'toggleActive'])->name('toggle-active');
        });
    });

    //  Documents 
    Route::prefix('documents')->name('documents.')->group(function () {
        Route::get('/',                          [DocumentController::class, 'index'])                ->name('index');
        Route::get('/create',                    [DocumentController::class, 'create'])               ->name('create');
        Route::post('/',                         [DocumentController::class, 'store'])                ->name('store');
        Route::get('/{document}',                [DocumentController::class, 'show'])                 ->name('show');
        Route::get('/{document}/edit',           [DocumentController::class, 'edit'])                 ->name('edit');
        Route::put('/{document}',                [DocumentController::class, 'update'])               ->name('update');
        Route::delete('/{document}',             [DocumentController::class, 'destroy'])              ->name('destroy');
        Route::get('/{document}/download',       [DocumentController::class, 'download'])             ->name('download');
        Route::get('/{document}/preview',        [DocumentController::class, 'preview'])              ->name('preview');  
        Route::post('/{document}/submit',        [DocumentController::class, 'submitForApproval'])    ->name('submit');

        // Approvals 
        Route::prefix('/{document}/approvals')->name('approvals.')->middleware('role:hr|manager|admin')->group(function () {
            Route::get('/',                      [DocumentApprovalController::class, 'index'])        ->name('index');
            Route::post('/approve',              [DocumentApprovalController::class, 'approve'])      ->name('approve');
            Route::post('/reject',               [DocumentApprovalController::class, 'reject'])       ->name('reject');
            Route::post('/request-revision',     [DocumentApprovalController::class, 'requestRevision'])->name('request-revision');
        });

        // Signature 
        Route::prefix('/{document}/signature')->name('signature.')->group(function () {
            Route::get('/',                      [DocumentSignatureController::class, 'show'])        ->name('show');
            Route::post('/send-otp',             [DocumentSignatureController::class, 'sendOtp'])     ->name('send-otp');
            Route::post('/sign',                 [DocumentSignatureController::class, 'sign'])        ->name('sign');
        });
    });
});