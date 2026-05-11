<?php

use App\Providers\AppServiceProvider;
use App\Providers\CookiesServiceProvider;
use App\Providers\Filament\AdminPanelProvider;
use App\Providers\FortifyServiceProvider;
use App\Providers\GoogleReviewsServiceProvider;
use App\Providers\SettingsVariableServiceProvider;

return [
    AppServiceProvider::class,
    CookiesServiceProvider::class,
    FortifyServiceProvider::class,
    AdminPanelProvider::class,
    SettingsVariableServiceProvider::class,
    GoogleReviewsServiceProvider::class,
];
