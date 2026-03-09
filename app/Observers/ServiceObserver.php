<?php

namespace App\Observers;

use App\Enums\ServiceCacheKey;
use App\Models\Service;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ServiceObserver
{
    /**
     * Handle the Service "created" event.
     */
    public function created(Service $service): void
    {
        if (empty($service->slug)) {
            $service->slug = Str::slug($service->title);
            $service->save();
        }
        $this->clearServiceCache($service);
    }

    /**
     * Clear all relevant caches for Service model.
     */
    private function clearServiceCache(Service $service): void
    {
        Cache::forget(ServiceCacheKey::ACTIVE->value);
        Cache::forget(ServiceCacheKey::SINGLE->value.$service->slug);
    }

    /**
     * Handle the Service "updated" event.
     */
    public function updated(Service $service): void
    {
        $this->clearServiceCache($service);
    }

    /**
     * Handle the Service "deleted" event.
     */
    public function deleted(Service $service): void
    {
        $this->clearServiceCache($service);
    }

    /**
     * Handle the Service "restored" event.
     */
    public function restored(Service $service): void
    {
        $this->clearServiceCache($service);
    }

    /**
     * Handle the Service "force deleted" event.
     */
    public function forceDeleted(Service $service): void
    {
        $this->clearServiceCache($service);
    }
}
