<?php

namespace App\Providers;

use App\Facades\GoogleReviews;
use App\Services\GoogleReviewsService;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class GoogleReviewsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('google-reviews', function ($app) {
            return new GoogleReviewsService;
        });

        $loader = AliasLoader::getInstance();
        $loader->alias('GoogleReviews', GoogleReviews::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
