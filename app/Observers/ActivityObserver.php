<?php

namespace App\Observers;

use App\Enums\ActivityCacheKey;
use App\Enums\ServiceCacheKey;
use App\Models\Activity;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ActivityObserver
{
    /**
     * Handle the Activity "created" event.
     */
    public function created(Activity $activity): void
    {
        if (empty($activity->slug)) {
            $activity->slug = Str::slug($activity->name);
        }
        $this->clearActivityCache($activity);
    }

    private function clearActivityCache(Activity $activity): void
    {
        Cache::forget(ActivityCacheKey::ACTIVE->value);
        Cache::forget(ServiceCacheKey::ACTIVE->value);
        $cities = $activity->cities()->with('services')->get();
        $services = $cities->pluck('services')->flatten();

        foreach ($services as $service) {
            Cache::forget(ServiceCacheKey::SINGLE->value.$service->slug);
        }

    }

    /**
     * Handle the Activity "updated" event.
     */
    public function updated(Activity $activity): void
    {
        $this->clearActivityCache($activity);
    }

    /**
     * Handle the Activity "deleted" event.
     */
    public function deleted(Activity $activity): void
    {
        $this->clearActivityCache($activity);
    }

    /**
     * Handle the Activity "restored" event.
     */
    public function restored(Activity $activity): void
    {
        $this->clearActivityCache($activity);
    }

    /**
     * Handle the Activity "force deleted" event.
     */
    public function forceDeleted(Activity $activity): void
    {
        $this->clearActivityCache($activity);
    }
}
