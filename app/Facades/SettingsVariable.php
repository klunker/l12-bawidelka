<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class SettingsVariable extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'settings-variable';
    }
}
