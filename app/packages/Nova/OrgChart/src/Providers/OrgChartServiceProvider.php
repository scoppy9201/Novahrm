<?php

namespace App\packages\Nova\OrgChart\src\Providers;

use Illuminate\Support\ServiceProvider;

class OrgChartServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'org-chart');
    }
}