<?php

namespace Nova\Auth\Http\Controllers;

use Nova\Auth\Http\Requests\SendOtpRequest;
use Nova\Auth\Http\Requests\VerifyOtpRequest;
use Nova\Auth\Http\Requests\ResetPasswordRequest;
use Nova\Auth\Services\ForgotPasswordService;
use Illuminate\Routing\Controller;

class ForgotPasswordController extends Controller
{
    public function __construct(
        private readonly ForgotPasswordService $service
    ) {}

    public function index()
    {
        return view('nova-auth::forgot-password');
    }

    public function sendOtp(SendOtpRequest $request)
    {
        $this->service->sendOtp($request->validated());
        return response()->json(['message' => 'Đã gửi mã OTP đến email của bạn.']);
    }

    public function verifyOtp(VerifyOtpRequest $request)
    {
        $result = $this->service->verifyOtp($request->validated());

        if (!$result) {
            return response()->json([
                'message' => 'Mã OTP không hợp lệ hoặc đã hết hạn.'
            ], 422);
        }

        return response()->json(['message' => 'Xác thực thành công.']);
    }

    public function reset(ResetPasswordRequest $request)
    {
        $result = $this->service->resetPassword($request->validated());

        if (!$result) {
            return response()->json([
                'message' => 'Phiên xác thực đã hết hạn. Vui lòng thử lại.'
            ], 422);
        }

        return response()->json(['message' => 'Đặt lại mật khẩu thành công.']);
    }
}