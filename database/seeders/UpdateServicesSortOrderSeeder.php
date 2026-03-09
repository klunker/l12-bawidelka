<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class UpdateServicesSortOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = Service::orderBy('id')->get();

        foreach ($services as $index => $service) {
            $service->update(['sort_order' => $index + 1]);
        }

        $this->command->info('Updated sort_order for '.$services->count().' services');
    }
}
