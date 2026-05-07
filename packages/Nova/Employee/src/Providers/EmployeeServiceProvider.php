<?php

namespace Nova\Employee\Providers;

use Illuminate\Support\ServiceProvider;
use Nova\Employee\Services\EmployeeService;

class EmployeeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(EmployeeService::class, function ($app) {
            return new EmployeeService();
        });
    }

    public function boot(): void
    {
        $this->loadViewsFrom(
            __DIR__ . '/../resources/views',
            'nova-employee'
        );

        $this->loadRoutesFrom(
            __DIR__ . '/../routes/web.php'
        );
    }
}