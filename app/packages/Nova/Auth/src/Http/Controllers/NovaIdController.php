<?php

namespace Nova\Auth\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Nova\Auth\Models\NovaIdToken;
use Nova\Auth\Mail\NovaIdMagicLinkMail;
use Nova\Auth\Mail\NovaIdOtpMail;
use Nova\Auth\Models\Employee;
use Illuminate\Support\Facades\Mail;

class NovaIdController extends Controller
{
    private const EXPIRES_MINUTES = 15;

    // POST /nova-id/send
    public function send(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'type'  => ['required', 'in:magic_link,otp'],
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email'    => 'Email không hợp lệ.',
            'type.in'        => 'Loại xác thực không hợp lệ.',
        ]);

        $email = strtolower($data['email']);
        $type  = $data['type'];

        // Silent fail — tránh user enumeration
        $user = Employee::where('email', $email)->first();
        if (! $user) {
            return response()->json(['ok' => true]);
        }

        // Xoá token cũ chưa dùng
        NovaIdToken::where('email', $email)
            ->where('type', $type)
            ->where('used', false)
            ->delete();

        if ($type === 'magic_link') {
            return $this->sendMagicLink($email);
        }

        return $this->sendOtp($email);
    }

    // GET /nova-id/verify?token=xxx
    public function verifyMagicLink(Request $request): RedirectResponse
    {
        $tokenStr = $request->query('token', '');

        $record = NovaIdToken::where('token', hash('sha256', $tokenStr))
            ->where('type', 'magic_link')
            ->first();

        if (! $record || ! $record->isValid()) {
            return redirect()->route('login')
                ->withErrors(['nova_id' => 'Liên kết không hợp lệ hoặc đã hết hạn.']);
        }

        $user = Employee::where('email', $record->email)->first();
        if (! $user) {
            return redirect()->route('login')
                ->withErrors(['nova_id' => 'Tài khoản không tồn tại.']);
        }

        $record->update(['used' => true]);

        Auth::login($user, remember: true);
        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }

    // POST /nova-id/verify-otp
    public function verifyOtp(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'otp'   => ['required', 'string', 'size:6'],
        ], [
            'otp.required' => 'Vui lòng nhập mã OTP.',
            'otp.size'     => 'Mã OTP gồm 6 chữ số.',
        ]);

        $email = strtolower($data['email']);

        $record = NovaIdToken::where('email', $email)
            ->where('type', 'otp')
            ->where('used', false)
            ->latest('created_at')
            ->first();

        if (! $record || ! $record->isValid()) {
            return response()->json([
                'message' => 'Mã OTP đã hết hạn. Vui lòng yêu cầu mã mới.',
            ], 422);
        }

        if (! hash_equals($record->otp, $data['otp'])) {
            return response()->json([
                'message' => 'Mã OTP không chính xác.',
            ], 422);
        }

        $user = Employee::where('email', $email)->first();
        if (! $user) {
            return response()->json(['message' => 'Tài khoản không tồn tại.'], 422);
        }

        $record->update(['used' => true]);

        Auth::login($user, remember: true);
        $request->session()->regenerate();

        return response()->json([
            'ok'       => true,
            'redirect' => redirect()->intended('/dashboard')->getTargetUrl(),
        ]);
    }

    // Private helpers 
    private function sendMagicLink(string $email): JsonResponse
    {
        $plainToken = Str::random(64);

        NovaIdToken::create([
            'email'      => $email,
            'token'      => hash('sha256', $plainToken),
            'type'       => 'magic_link',
            'expires_at' => now()->addMinutes(self::EXPIRES_MINUTES),
        ]);

        $link = URL::temporarySignedRoute(
            'nova-id.verify',
            now()->addMinutes(self::EXPIRES_MINUTES),
            ['token' => $plainToken]
        );

        // Đổi queue → send để gửi ngay không cần worker
        Mail::to($email)->send(new NovaIdMagicLinkMail($link));

        return response()->json(['ok' => true]);
    }

    private function sendOtp(string $email): JsonResponse
    {
        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        NovaIdToken::create([
            'email'      => $email,
            'token'      => Str::random(64),
            'otp'        => $otp,
            'type'       => 'otp',
            'expires_at' => now()->addMinutes(self::EXPIRES_MINUTES),
        ]);

        // Truyền $email + type 'login' để view hiển thị đúng nội dung
        Mail::to($email)->send(new NovaIdOtpMail($otp, $email, 'login'));

        return response()->json(['ok' => true]);
    }
}