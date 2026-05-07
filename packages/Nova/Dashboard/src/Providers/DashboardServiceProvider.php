<?php

namespace Nova\Dashboard\Providers;

use Illuminate\Support\ServiceProvider;

class DashboardServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nova-dashboard');

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang','nova-dashboard');
    }
}