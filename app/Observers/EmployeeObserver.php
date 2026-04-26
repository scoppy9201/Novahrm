<?php

namespace App\Observers;

use Nova\Auth\Models\Employee; 
use Illuminate\Support\Facades\Hash;

class EmployeeObserver
{
    public function creating(Employee $employee): void
    {
        if (empty($employee->password)) {
            $employee->password = Hash::make($employee->email);
        }
    }

    public function created(Employee $employee): void {}
    public function updated(Employee $employee): void {}
    public function deleted(Employee $employee): void {}
    public function restored(Employee $employee): void {}
    public function forceDeleted(Employee $employee): void {}
}
