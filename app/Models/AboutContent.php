<?php

namespace App\Models;

use App\Enums\AboutContentCacheKey;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class AboutContent extends Model
{
    protected $fillable = [
        'content',
        'isActive',
    ];

    protected $casts = [
        'isActive' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget(AboutContentCacheKey::ACTIVE->value));

        static::deleted(fn () => Cache::forget(AboutContentCacheKey::ACTIVE->value));
    }

    /**
     * Scope a query to only include active AboutContent.
     *
     * @param  Builder<AboutContent>  $query
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('isActive', true);
    }
}
