<?php

namespace App\packages\Nova\document\src\Providers;

use App\packages\Nova\document\src\Models\Document;
use App\packages\Nova\document\src\Policies\DocumentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;

class DocumentServiceProvider extends AuthServiceProvider  
{
    protected $policies = [
        Document::class => DocumentPolicy::class,  
    ];

    public function boot(): void
    {
        $this->registerPolicies();  
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'documents');
    }

    public function register(): void
    {
        //
    }
}