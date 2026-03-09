<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class GoogleReviews extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'google-reviews';
    }
}
