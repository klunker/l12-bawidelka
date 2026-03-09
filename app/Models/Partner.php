<?php

namespace App\Models;

use App\Enums\PartnerCacheKey;
use Database\Factories\PartnerFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Partner extends Model
{
    /** @use HasFactory<PartnerFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'photo',
        'url',
        'description',
        'isActive',
        'order',
    ];

    protected $casts = [
        'isActive' => 'boolean',
        'order' => 'integer',
    ];

    protected $appends = ['logo_url', 'photo_url'];

    protected static function booted(): void
    {
        static::saving(function (Partner $partner) {
            if (empty($partner->slug) && ! empty($partner->name)) {
                $partner->slug = \Str::slug($partner->name);
            }
        });

        static::saved(fn () => Cache::forget(PartnerCacheKey::ACTIVE->value));
        static::deleted(fn () => Cache::forget(PartnerCacheKey::ACTIVE->value));
    }

    /**
     * Scope a query to only include active partners.
     *
     * @param  Builder<Partner>  $query
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('isActive', true);
    }

    /**
     * Get the logo URL attribute.
     */
    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? Storage::disk('public')->url($this->logo) : null;
    }

    /**
     * Get the photo URL attribute.
     */
    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? Storage::disk('public')->url($this->photo) : null;
    }

    /**
     * Find a partner by slug.
     */
    public static function findBySlug(string $slug): ?Partner
    {
        return static::where('slug', $slug)->first();
    }
}
