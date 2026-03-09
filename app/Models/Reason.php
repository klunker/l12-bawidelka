<?php

namespace App\Models;

use App\Enums\ReasonCacheKey;
use Database\Factories\ReasonFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Reason extends Model
{
    /** @use HasFactory<ReasonFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'image',
        'attachments',
        'isActive',
    ];

    protected $casts = [
        'attachments' => 'array',
        'isActive' => 'boolean',
    ];

    protected $appends = ['image_url'];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget(ReasonCacheKey::ACTIVE->value));
        static::deleted(fn () => Cache::forget(ReasonCacheKey::ACTIVE->value));
    }

    /**
     * Scope a query to only include active reasons.
     *
     * @param  Builder<Reason>  $query
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('isActive', true);
    }

    /**
     * Get the image URL attribute.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }
}
