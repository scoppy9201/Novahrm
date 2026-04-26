<?php

namespace App\packages\Nova\Auth\src\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nova-auth');

        $this->registerRateLimiters();
    }

    protected function registerRateLimiters(): void
    {
        // Gửi Magic Link / OTP: tối đa 5 lần / 10 phút / per email+IP
        RateLimiter::for('nova-id-send', function ($request) {
            return Limit::perMinutes(10, 5)
                ->by(strtolower($request->input('email')) . '|' . $request->ip())
                ->response(fn () => response()->json([
                    'message' => 'Quá nhiều yêu cầu. Vui lòng thử lại sau.',
                ], 429));
        });

        // Verify OTP: tối đa 10 lần / 10 phút / per email+IP
        RateLimiter::for('nova-id-otp', function ($request) {
            return Limit::perMinutes(10, 10)
                ->by(strtolower($request->input('email')) . '|' . $request->ip())
                ->response(fn () => response()->json([
                    'message' => 'Quá nhiều lần thử. Vui lòng thử lại sau.',
                ], 429));
        });
    }
}