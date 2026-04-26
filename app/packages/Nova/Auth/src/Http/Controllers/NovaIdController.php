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
    // Token hết hạn sau 15 phút
    private const EXPIRES_MINUTES = 15;

    // POST /nova-id/send
    // Body: { email: string, type: 'magic_link'|'otp' }
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

        // Kiểm tra user tồn tại — silent fail để tránh user enumeration
        $user = Employee::where('email', $email)->first();
        if (! $user) {
            // Trả về ok: true để FE không biết email có tồn tại không
            return response()->json(['ok' => true]);
        }

        // Xoá token cũ chưa dùng của email này (cùng type)
        NovaIdToken::where('email', $email)
            ->where('type', $type)
            ->where('used', false)
            ->delete();

        if ($type === 'magic_link') {
            return $this->sendMagicLink($email);
        }

        return $this->sendOtp($email);
    }

    // GET /nova-id/verify?token=xxx  (click từ email)
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

        // Đánh dấu đã dùng
        $record->update(['used' => true]);

        Auth::login($user, remember: true);
        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }

    // POST /nova-id/verify-otp
    // Body: { email: string, otp: string }
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

        // So sánh OTP (hash để tránh timing attack)
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
            'token'      => hash('sha256', $plainToken),  // lưu hash
            'type'       => 'magic_link',
            'expires_at' => now()->addMinutes(self::EXPIRES_MINUTES),
        ]);

        $link = URL::temporarySignedRoute(
            'nova-id.verify',
            now()->addMinutes(self::EXPIRES_MINUTES),
            ['token' => $plainToken]
        );

        Mail::to($email)->queue(new NovaIdMagicLinkMail($link));

        return response()->json(['ok' => true]);
    }

    private function sendOtp(string $email): JsonResponse
    {
        // OTP 6 chữ số, padding 0 nếu cần
        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        NovaIdToken::create([
            'email'      => $email,
            'token'      => Str::random(64), // bắt buộc unique, không dùng
            'otp'        => $otp,
            'type'       => 'otp',
            'expires_at' => now()->addMinutes(self::EXPIRES_MINUTES),
        ]);

        Mail::to($email)->queue(new NovaIdOtpMail($otp));

        return response()->json(['ok' => true]);
    }
}