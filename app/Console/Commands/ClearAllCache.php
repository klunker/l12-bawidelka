<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'app:clear-all-cache', description: 'Clear all application caches (cache, route, config, view) and restart Supervisor worker')]
class ClearAllCache extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Clearing all caches...');

        Artisan::call('cache:clear');
        $this->info('Application cache cleared.');

        Artisan::call('route:clear');
        $this->info('Route cache cleared.');

        Artisan::call('config:clear');
        $this->info('Configuration cache cleared.');

        Artisan::call('view:clear');
        $this->info('Compiled views cleared.');

        $checkSupervisor = Process::run('command -v supervisorctl');

        if ($checkSupervisor->successful() && ! empty($checkSupervisor->output())) {
            $this->info('Restarting Supervisor worker...');

            $result = Process::run('supervisorctl restart laravel-bawidelka-worker:*');

            if ($result->successful()) {
                $this->info('Supervisor worker restarted successfully.');
            } else {
                $this->error('Failed to restart Supervisor worker: '.$result->errorOutput());
            }
        } else {
            $this->warn('Supervisor not found. Skipping worker restart.');
        }

        $this->info('All tasks completed successfully!');
    }
}
