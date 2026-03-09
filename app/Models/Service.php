<?php

namespace App\Models;

use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Service extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'slug',
        'title',
        'sub_title',
        'description',
        'description_additional',
        'image',
        'headerImage',
        'template',
        'options',
        'attachments',
        'isActive',
        'sort_order',
    ];

    protected $casts = [
        'options' => 'array',
        'attachments' => 'array',
        'attachments_urls' => 'array',
        'isActive' => 'boolean',
        'sub_title' => 'string',
    ];

    protected $appends = ['image_url', 'header_image_url', 'attachments_urls'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($service) {
            if (empty($service->slug) && ! empty($service->title)) {
                $service->slug = Str::slug($service->title);
            }
        });
    }

    /**
     * @return MorphOne<SeoMeta, $this>
     */
    public function seoMeta(): MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }

    /**
     * @return BelongsToMany<City, $this>
     */
    public function cities(): BelongsToMany
    {
        return $this->belongsToMany(City::class);
    }

    /**
     * Get the image URL attribute.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }

    /**
     * Get the header image URL attribute.
     */
    public function getHeaderImageUrlAttribute(): ?string
    {
        return $this->headerImage ? Storage::disk('public')->url($this->headerImage) : null;
    }

    /**
     * Get the attachments URLs attribute.
     *
     * @return array<string, string>
     */
    public function getAttachmentsUrlsAttribute(): array
    {
        return $this->attachments ? array_map(function ($attachment) {
            $attachment['url'] = Storage::disk('public')->url($attachment['file']);

            return $attachment;
        }, $this->attachments) : [];
    }

    /**
     * @param  Builder<Service>  $query
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('isActive', true);
    }

    /**
     * @param  Builder<Service>  $query
     */
    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderBy('title');
    }
}
