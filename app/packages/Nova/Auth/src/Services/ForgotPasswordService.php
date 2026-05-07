<?php

namespace Nova\Auth\Services;

use Nova\Auth\Mail\NovaIdOtpMail;
use Nova\Auth\Models\Employee;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordService
{
    public function sendOtp(array $data): void
    {
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $key = 'otp_' . md5($data['email']);

        Cache::put($key, $otp, now()->addMinutes(10));

        Mail::to($data['email'])->send(
            new NovaIdOtpMail($otp, $data['email'], 'forgot_password')
        );
    }

    public function verifyOtp(array $data): bool
    {
        $key       = 'otp_' . md5($data['email']);
        $cachedOtp = Cache::get($key);

        if (!$cachedOtp || $cachedOtp !== $data['otp']) {
            return false;
        }

        Cache::put(
            'otp_verified_' . md5($data['email']),
            true,
            now()->addMinutes(10)
        );

        return true;
    }

    public function resetPassword(array $data): bool
    {
        $verifiedKey = 'otp_verified_' . md5($data['email']);

        if (!Cache::get($verifiedKey)) {
            return false;
        }

        $employee = Employee::where('email', $data['email'])->firstOrFail();
        $employee->update(['password' => Hash::make($data['password'])]);

        Cache::forget('otp_' . md5($data['email']));
        Cache::forget($verifiedKey);

        return true;
    }
}