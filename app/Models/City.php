<?php

namespace App\Models;

use App\Enums\CityCacheKey;
use Database\Factories\CityFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Cache;

class City extends Model
{
    /** @use HasFactory<CityFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'address',
        'postal_code',
        'phone',
        'facebook',
        'instagram',
        'active',
        'nip',
        'regon',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget(CityCacheKey::ACTIVE->value));
        static::deleted(fn () => Cache::forget(CityCacheKey::ACTIVE->value));
    }

    /** @return BelongsToMany<Service, $this, Pivot, 'pivot'> */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }

    /** @return BelongsToMany<Activity, $this, Pivot, 'pivot'> */
    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class);
    }

    /**
     * Scope a query to only include active cities.
     *
     * @param  Builder<City>  $query
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('active', true);
    }
}
