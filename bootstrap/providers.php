<?php

return [
    App\Providers\AppServiceProvider::class,
    App\packages\Nova\Core\src\Providers\CoreServiceProvider::class,
    App\packages\Nova\Auth\src\Providers\AuthServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
    App\Providers\Filament\EmployeePanelProvider::class,
    Spatie\Permission\PermissionServiceProvider::class
];
