<?php

namespace App\Models;

use App\Enums\FaqCacheKey;
use Database\Factories\FaqFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Faq extends Model
{
    /** @use HasFactory<FaqFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'question',
        'answer',
        'isActive',
        'sort_order',
    ];

    protected $casts = [
        'isActive' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget(FaqCacheKey::ACTIVE->value));
        static::deleted(fn () => Cache::forget(FaqCacheKey::ACTIVE->value));
    }

    /**
     * Scope a query to only include active faqs.
     *
     * @param  Builder<Faq>  $query
     */
    protected function scopeActive(Builder $query): void
    {
        $query->where('isActive', true)
            ->orderBy('sort_order');
    }

    /**
     * @param  Builder<Faq>  $query
     */
    protected function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort_order', 'asc');
    }
}
