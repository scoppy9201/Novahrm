<?php

namespace Nova\Profile\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Nova\Profile\Http\Requests\UpdatePasswordRequest;
use Nova\Profile\Http\Requests\UpdateNotificationsRequest;
use Nova\Profile\Http\Requests\UpdateProfileRequest;
use Nova\Profile\Services\ProfileService;

class ProfileController extends Controller
{
    public function __construct(
        private readonly ProfileService $service
    ) {}

    public function index()
    {
        /** @var \Nova\Auth\Models\Employee $employee */
        $employee = Auth::user();
        $employee->load('notificationPreference');

        return view('profile::profile', compact('employee'));
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $this->service->updatePassword($request, Auth::user());

        return redirect()
            ->route('profile.index', ['#bao-mat'])
            ->with('success', 'Mật khẩu đã được cập nhật thành công.');
    }

    public function suspend(Request $request)
    {
        $employee = Auth::user();

        $this->service->suspend($employee);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('warning', 'Tài khoản của bạn đã bị đình chỉ.');
    }

    public function destroy(Request $request)
    {
        $employee = Auth::user();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $this->service->destroy($employee);

        return redirect()
            ->route('login')
            ->with('info', 'Tài khoản của bạn đã được xoá.');
    }

    public function updateNotifications(UpdateNotificationsRequest $request)
    {
        $this->service->updateNotifications($request, Auth::user());

        return redirect()
            ->route('profile.index', ['#email'])
            ->with('success', 'Cài đặt thông báo đã được cập nhật.');
    }

    public function update(UpdateProfileRequest $request)
    {
        $this->service->update($request, Auth::user());

        return redirect()
            ->route('profile.index')
            ->with('success', 'Hồ sơ đã được cập nhật thành công.');
    }
}