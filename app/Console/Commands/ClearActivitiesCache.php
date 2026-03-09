<?php

namespace App\Console\Commands;

use App\Enums\ActivityCacheKey;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearActivitiesCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-activities-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear activities cache only';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Clearing activities cache...');
        Cache::forget(ActivityCacheKey::ACTIVE->value);
        $this->info('Activities cache cleared successfully!');
    }
}
