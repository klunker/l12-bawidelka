<?php

namespace App\Console\Commands;

use App\Enums\ActivityCacheKey;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'app:clear-activities-cache', description: 'Clear activities cache only')]
class ClearActivitiesCache extends Command
{
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
