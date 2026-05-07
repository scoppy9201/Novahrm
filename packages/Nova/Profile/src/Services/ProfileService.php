<?php

namespace Nova\Profile\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Nova\Auth\Models\Employee;
use Nova\Profile\Http\Requests\UpdatePasswordRequest;
use Nova\Profile\Http\Requests\UpdateNotificationsRequest;
use Nova\Profile\Http\Requests\UpdateProfileRequest;
use Nova\Profile\Models\NotificationPreference;

class ProfileService
{
    public function updatePassword(UpdatePasswordRequest $request, Employee $employee): void
    {
        if (!Hash::check($request->current_password, $employee->getAuthPassword())) {
            throw ValidationException::withMessages([
                'current_password' => 'Mật khẩu hiện tại không đúng.',
            ]);
        }

        if (Hash::check($request->password, $employee->getAuthPassword())) {
            throw ValidationException::withMessages([
                'password' => 'Mật khẩu mới không được trùng với mật khẩu hiện tại.',
            ]);
        }

        $employee->password = $request->password;
        $employee->save();
    }

    public function suspend(Employee $employee): void
    {
        $employee->is_active = false;
        $employee->save();
    }

    public function destroy(Employee $employee): void
    {
        $employee->delete();
    }

    public function updateNotifications(UpdateNotificationsRequest $request, Employee $employee): void
    {
        NotificationPreference::updateOrCreate(
            ['employee_id' => $employee->id],
            [
                'notif_attendance' => $request->notif_attendance,
                'notif_payroll'    => $request->notif_payroll,
            ]
        );
    }

    public function update(UpdateProfileRequest $request, Employee $employee): void
    {
        $data = $request->only([
            'first_name', 'last_name', 'phone', 'date_of_birth',
            'gender', 'address', 'language', 'job_title', 'occupation',
            'hire_date', 'department_id', 'office_id', 'position_id',
            'manager_id', 'email_personal', 'bio',
        ]);

        if ($request->hasFile('avatar')) {
            if ($employee->avatar) {
                Storage::disk('public')->delete($employee->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $employee->fill($data);
        $employee->save();
    }
}