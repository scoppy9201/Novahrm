<?php

namespace App\packages\Nova\Core\src\Providers;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(
            __DIR__.'/../resources/views', 
            'core'
        );

        $this->loadRoutesFrom(
            __DIR__.'/../routes/web.php'
        );
    }
}