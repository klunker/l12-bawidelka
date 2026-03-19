<?php

namespace App\Models;

use App\Enums\ActivityCacheKey;
use App\Observers\ActivityObserver;
use Database\Factories\ActivityFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[ObservedBy(ActivityObserver::class)]
class Activity extends Model
{
    /** @use HasFactory<ActivityFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'price',
        'weekendPrice',
        'duration',
        'order',
        'ageFrom',
        'ageTo',
        'maxChildren',
        'numChildren',
        'extra_price',
        'features',
        'badge',
        'color',
        'isActive',
    ];

    protected $casts = [
        'features' => 'array',
        'isActive' => 'boolean',
        'numChildren' => 'integer',
        'extra_price' => 'decimal:2',
    ];

    protected $appends = ['image_url'];

    protected static function boot()
    {
        parent::boot();

        // Generate slug and clear cache when activity is being saved
        static::saving(function ($activity) {

            if (empty($activity->slug) && ! empty($activity->name)) {
                $activity->slug = Str::slug($activity->name);
            }

            Cache::forget(ActivityCacheKey::ACTIVE->value);
        });

        // Clear cache when activity is deleted
        static::deleted(function () {
            Cache::forget(ActivityCacheKey::ACTIVE->value);
        });
    }

    /** @return BelongsToMany<City, $this, Pivot, 'pivot'> */
    public function cities(): BelongsToMany
    {
        return $this->belongsToMany(City::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }

    /**
     * Scope a query to only include active Activities
     *
     * @param  Builder<Activity>  $builder
     */
    public function scopeActive(Builder $builder): void
    {
        $builder->where('isActive', true);
    }
}
