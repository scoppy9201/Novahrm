<?php

namespace App\packages\Nova\Department\src\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\DepartmentService;

class DepartmentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(DepartmentService::class, DepartmentService::class);
    }

    public function boot(): void
    {
        $this->loadRoutes();
        $this->loadViews();
    }

    private function loadRoutes(): void
    {
        $this->loadRoutesFrom(
            __DIR__ . '/../routes/web.php'
        );
    }

    private function loadViews(): void
    {
        $this->loadViewsFrom(
            __DIR__ . '/../resources/views', 'nova-department'
        );
    }
}