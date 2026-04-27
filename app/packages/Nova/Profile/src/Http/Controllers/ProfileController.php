<?php

namespace App\packages\Nova\Profile\src\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use App\packages\Nova\Profile\src\Models\NotificationPreference;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        /** @var \Nova\Auth\Models\Employee $employee */
        $employee = Auth::user();
        $employee->load('notificationPreference');

        return view('profile::profile', compact('employee'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'password.required'         => 'Vui lòng nhập mật khẩu mới.',
            'password.confirmed'        => 'Xác nhận mật khẩu không khớp.',
            'password.min'              => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'password.mixed_case'       => 'Mật khẩu phải chứa cả chữ hoa và chữ thường.',
            'password.numbers'          => 'Mật khẩu phải chứa ít nhất một chữ số.',
        ]);

        /** @var \Nova\Auth\Models\Employee $employee */
        $employee = Auth::user();

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

        return redirect()
            ->route('profile.index', ['#bao-mat'])
            ->with('success', 'Mật khẩu đã được cập nhật thành công.');
    }

    /**
     * Đình chỉ tài khoản — set is_active = false + logout
     */
    public function suspend(Request $request)
    {
        /** @var \Nova\Auth\Models\Employee $employee */
        $employee = Auth::user();

        $employee->is_active = false;
        $employee->save();

        // Logout + xoá session
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('warning', 'Tài khoản của bạn đã bị đình chỉ.');
    }

    /**
     * Xoá tài khoản — soft delete + logout
     */
    public function destroy(Request $request)
    {
        /** @var \Nova\Auth\Models\Employee $employee */
        $employee = Auth::user();

        // Logout trước khi xoá
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Soft delete — deleted_at được set, data vẫn còn trong DB
        $employee->delete();

        return redirect()
            ->route('login')
            ->with('info', 'Tài khoản của bạn đã được xoá.');
    }

    public function updateNotifications(Request $request)
    {
        $request->validate([
            'notif_attendance' => ['required', 'in:all,daily,none'],
            'notif_payroll'    => ['required', 'in:monthly,none'],
        ], [
            'notif_attendance.required' => 'Vui lòng chọn cài đặt thông báo chấm công.',
            'notif_attendance.in'       => 'Giá trị thông báo chấm công không hợp lệ.',
            'notif_payroll.required'    => 'Vui lòng chọn cài đặt thông báo lương.',
            'notif_payroll.in'          => 'Giá trị thông báo lương không hợp lệ.',
        ]);

        /** @var \Nova\Auth\Models\Employee $employee */
        $employee = Auth::user();

        // Nếu chưa có thì tạo mới, có rồi thì update
        NotificationPreference::updateOrCreate(
            ['employee_id' => $employee->id],
            [
                'notif_attendance' => $request->notif_attendance,
                'notif_payroll'    => $request->notif_payroll,
            ]
        );

        return redirect()
            ->route('profile.index', ['#email'])
            ->with('success', 'Cài đặt thông báo đã được cập nhật.');
    }

    public function update(Request $request)
    {
        /** @var \Nova\Auth\Models\Employee $employee */
        $employee = Auth::user();

        $request->validate([
            'first_name'     => ['required', 'string', 'max:100', 'regex:/^[\p{L}\s]+$/u'],
            'last_name'      => ['required', 'string', 'max:100', 'regex:/^[\p{L}\s]+$/u'],
            'phone'          => ['nullable', 'regex:/^(\+84|0)\d{9}$/'],
            'date_of_birth'  => ['nullable', 'date', 'before:' . now()->subYears(18)->format('Y-m-d')],
            'gender'         => ['nullable', 'in:male,female,other'],
            'address'        => ['nullable', 'string', 'max:255'],
            'language'       => ['nullable', 'in:vi,en'],
            'job_title'      => ['nullable', 'string', 'max:100'],
            'occupation'     => ['nullable', 'string', 'max:100'],
            'department_id'  => ['nullable', 'integer', 'exists:departments,id'],
            'office_id'      => ['nullable', 'integer', 'exists:offices,id'],
            'position_id'    => ['nullable', 'integer', 'exists:positions,id'],
            'manager_id'     => ['nullable', 'integer', 'exists:employees,id'],
            'email_personal' => ['nullable', 'email', 'max:255', 'regex:/^[^@]+@gmail\.com$/i'],
            'bio'            => ['nullable', 'string', 'max:1000'],
            'avatar'         => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'hire_date'      => ['nullable', 'date'],
        ], [
            'first_name.required'    => 'Vui lòng nhập họ.',
            'first_name.regex'       => 'Họ không được chứa số hoặc ký tự đặc biệt.',
            'last_name.required'     => 'Vui lòng nhập tên.',
            'last_name.regex'        => 'Tên không được chứa số hoặc ký tự đặc biệt.',
            'phone.regex'            => 'Số điện thoại phải có 10 chữ số, bắt đầu bằng 0 hoặc +84.',
            'date_of_birth.before'   => 'Bạn phải đủ 18 tuổi.',
            'date_of_birth.date'     => 'Ngày sinh không hợp lệ.',
            'email_personal.email'   => 'Email cá nhân không hợp lệ.',
            'email_personal.regex'   => 'Email cá nhân phải có đuôi @gmail.com.',
            'avatar.file'           => 'File phải là ảnh.',
            'avatar.max'             => 'Ảnh không được vượt quá 2MB.',
        ]);

        $data = $request->only([
            'first_name', 'last_name', 'phone', 'date_of_birth',
            'gender', 'address', 'language', 'job_title', 'occupation',
            'hire_date',
            'department_id', 'office_id', 'position_id', 'manager_id',
            'email_personal', 'bio',
        ]);

        // Xử lý avatar
        if ($request->hasFile('avatar')) {
            // Xoá avatar cũ nếu có
            if ($employee->avatar) {
                Storage::disk('public')->delete($employee->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $employee->fill($data);
        $employee->save();

        return redirect()
            ->route('profile.index')
            ->with('success', 'Hồ sơ đã được cập nhật thành công.');
    }
}