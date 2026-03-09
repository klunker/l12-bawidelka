<?php

namespace App\Models;

use Database\Factories\GoogleReviewFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleReview extends Model
{
    /** @use HasFactory<GoogleReviewFactory> */
    use HasFactory;

    protected $fillable = [
        'author_name',
        'author_url',
        'profile_photo_url',
        'rating',
        'text',
        'language',
        'original_language',
        'translated',
        'relative_time_description',
        'time',
        'is_active',
    ];

    protected $casts = [
        'rating' => 'integer',
        'time' => 'integer',
        'translated' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Scope a query to only include active google reviews.
     *
     * @param  Builder<GoogleReview>  $query
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }
}
