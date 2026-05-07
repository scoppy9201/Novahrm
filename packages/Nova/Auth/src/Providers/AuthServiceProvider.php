<?php

namespace Nova\Auth\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

use Nova\document\Models\Document;
use Nova\document\Policies\DocumentPolicy;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Đăng ký policies
        Gate::policy(Document::class, DocumentPolicy::class);

        // Đăng ký routes
        Route::middleware(['web'])->group(__DIR__ . '/../routes/web.php');

        // Đăng ký views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nova-auth');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang','nova-auth');

        // Đăng ký rate limiters
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