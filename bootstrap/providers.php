<?php

return [
    App\Providers\AppServiceProvider::class,
    App\packages\Nova\Core\src\Providers\CoreServiceProvider::class,
    App\packages\Nova\Auth\src\Providers\AuthServiceProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
    App\packages\Nova\Dashboard\src\Providers\DashboardServiceProvider::class,
    App\packages\Nova\Profile\src\Providers\ProfileServiceProvider::class,
    App\packages\Nova\OrgChart\src\Providers\OrgChartServiceProvider::class,
    App\packages\Nova\Document\src\Providers\DocumentServiceProvider::class,
];
