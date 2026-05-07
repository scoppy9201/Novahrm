<?php

namespace Nova\OrgChart\Providers;
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
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'org-chart');
    }
}
