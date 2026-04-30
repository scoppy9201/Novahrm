<?php

namespace App\packages\Nova\Employee\src\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\EmployeeService;

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