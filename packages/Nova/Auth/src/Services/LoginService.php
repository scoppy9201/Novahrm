<?php

namespace Nova\Auth\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginService
{
    private int $maxAttempts = 5;
    private int $decaySeconds = 300;

    public function throttleKey(Request $request): string
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }

    public function checkThrottle(Request $request): void
    {
        $key = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($key, $this->maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => "Quá nhiều lần thử. Vui lòng thử lại sau {$seconds} giây.",
            ]);
        }
    }

    public function attempt(Request $request): void
    {
        $key = $this->throttleKey($request);

        if (!Auth::attempt(
            $request->only('email', 'password'),
            $request->boolean('remember')
        )) {
            RateLimiter::hit($key, $this->decaySeconds);

            throw ValidationException::withMessages([
                'email' => 'Email hoặc mật khẩu không chính xác.',
            ]);
        }

        RateLimiter::clear($key);
    }

    public function persistSession(Request $request): void
    {
        $request->session()->regenerate();
        $request->session()->save();

        DB::table('sessions')
            ->where('id', $request->session()->getId())
            ->update(['user_id' => Auth::id()]);
    }

    public function logout(Request $request): void
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}