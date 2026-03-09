<?php

namespace App\Providers;

use App\Facades\SettingsVariable;
use App\Services\SettingsVariableService;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class SettingsVariableServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('settings-variable', function ($app) {
            return new SettingsVariableService;
        });

        $loader = AliasLoader::getInstance();
        $loader->alias('SettingsVariable', SettingsVariable::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
