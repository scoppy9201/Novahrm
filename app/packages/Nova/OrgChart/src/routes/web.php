<?php

use App\packages\Nova\Auth\src\Models\Employee;
use App\packages\Nova\OrgChart\src\Http\Controllers\OrgChartController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {

    Route::prefix('hrm/org-chart')->name('org-chart.')->group(function () {
        Route::get('/', [OrgChartController::class, 'index'])->name('index');
        Route::get('/tree', [OrgChartController::class, 'tree'])->name('tree');
        Route::post('/departments', [OrgChartController::class, 'store'])->name('department.store'); 
        Route::put('/departments/{department}', [OrgChartController::class, 'update'])->name('department.update');
        Route::delete('/departments/{department}', [OrgChartController::class, 'destroy'])->name('department.destroy');
        Route::patch('/departments/{department}/move', [OrgChartController::class, 'move'])->name('department.move');
        Route::get('/employee/{employee}/chain', [OrgChartController::class, 'employeeChain'])
            ->name('employee.chain')
            ->where('employee', '[0-9]+');
    });
});