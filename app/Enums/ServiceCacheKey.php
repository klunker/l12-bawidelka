<?php

namespace App\Enums;

enum ServiceCacheKey: string
{
    case ACTIVE = 'services:active:all';
    case SINGLE = 'service:';
}
