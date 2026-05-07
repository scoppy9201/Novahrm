<?php

use Nova\Employee\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BankLookupController;

Route::middleware(['web', 'auth'])->prefix('hr')->name('hr.')->group(function () {
    Route::get('employees/search', [EmployeeController::class, 'search'])->name('employees.search');
    Route::get('employees/export', [EmployeeController::class, 'export'])->name('employees.export');
    Route::resource('employees', EmployeeController::class);
    Route::post('employees/{employee}/terminate', [EmployeeController::class, 'terminate'])->name('employees.terminate');
    Route::post('employees/{employee}/reinstate', [EmployeeController::class, 'reinstate'])->name('employees.reinstate');
    Route::post('employees/{employee}/transfer',  [EmployeeController::class, 'transfer'])->name('employees.transfer');
    Route::post('employees/{employee}/avatar',    [EmployeeController::class, 'updateAvatar'])->name('employees.avatar.update');
    Route::delete('employees/{employee}/avatar',  [EmployeeController::class, 'deleteAvatar'])->name('employees.avatar.delete');
    Route::post('employees/{id}/restore',         [EmployeeController::class, 'restore'])->name('employees.restore');
    Route::delete('employees/{id}/force-delete', [EmployeeController::class, 'forceDelete'])->name('employees.force-delete');
    Route::get('bank/banks',          [BankLookupController::class, 'banks'])->name('bank.banks');
    Route::post('bank/lookup',        [BankLookupController::class, 'lookup'])->name('bank.lookup');
});