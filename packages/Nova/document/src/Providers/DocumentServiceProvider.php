<?php

namespace Nova\document\Providers;

use Nova\document\Models\Document;
use Nova\document\Policies\DocumentPolicy;
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
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'documents');
    }

    public function register(): void
    {
        //
    }
}
