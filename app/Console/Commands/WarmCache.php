<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Service;
use App\Models\Partner;
use App\Models\Activity;

class WarmCache extends Command
{
    protected $signature = 'cache:warm';
    protected $description = 'Warm up application cache for better performance';

    public function handle(): int
    {
        $this->info('Warming up cache...');
        $start = microtime(true);
        // Warm up services cache
        $services = Service::with('cities')->active()->orderBy('services.sort_order')->get();
        foreach ($services as $service) {
            $service->image_url;
            $service->header_image_url;
            $service->attachments_urls;
        }
        // Warm up partners cache
        $partners = Partner::active()->orderBy('order')->get();
        foreach ($partners as $partner) {
            $partner->logo_url;
            $partner->photo_url;
        }
        // Warm up activities cache
        $activities = Activity::with('cities')->active()->orderBy('order')->get();
        foreach ($activities as $activity) {
            $activity->image_url;
        }
        $time = round((microtime(true) - $start) * 1000, 2);
        $this->info("Cache warmed in {$time} ms");
        return Command::SUCCESS;
    }
}
