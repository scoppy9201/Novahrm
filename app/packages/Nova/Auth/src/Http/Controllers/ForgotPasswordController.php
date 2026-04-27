<?php

namespace Nova\Auth\Http\Controllers;

use Nova\Auth\Mail\NovaIdOtpMail;
use Nova\Auth\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('nova-auth::forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:employees,email'],
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email'    => 'Email không hợp lệ.',
            'email.exists'   => 'Không tìm thấy tài khoản với email này.',
        ]);

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $key = 'otp_' . md5($request->email);

        Cache::put($key, $otp, now()->addMinutes(10));

        Mail::to($request->email)->send(new NovaIdOtpMail($otp, $request->email, 'forgot_password'));

        return response()->json(['message' => 'Đã gửi mã OTP đến email của bạn.']);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp'   => ['required', 'string', 'size:6'],
        ]);

        $key       = 'otp_' . md5($request->email);
        $cachedOtp = Cache::get($key);

        if (!$cachedOtp || $cachedOtp !== $request->otp) {
            return response()->json([
                'message' => 'Mã OTP không hợp lệ hoặc đã hết hạn.'
            ], 422);
        }

        Cache::put('otp_verified_' . md5($request->email), true, now()->addMinutes(10));

        return response()->json(['message' => 'Xác thực thành công.']);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email', 'exists:employees,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.exists'       => 'Không tìm thấy tài khoản với email này.',
            'password.min'       => 'Mật khẩu tối thiểu 8 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ]);

        $verifiedKey = 'otp_verified_' . md5($request->email);

        if (!Cache::get($verifiedKey)) {
            return response()->json([
                'message' => 'Phiên xác thực đã hết hạn. Vui lòng thử lại.'
            ], 422);
        }

        $employee = Employee::where('email', $request->email)->firstOrFail();
        $employee->update(['password' => Hash::make($request->password)]);

        Cache::forget('otp_' . md5($request->email));
        Cache::forget($verifiedKey);

        return response()->json(['message' => 'Đặt lại mật khẩu thành công.']);
    }
}