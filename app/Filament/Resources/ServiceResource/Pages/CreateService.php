<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Enums\ServiceCacheKey;
use App\Filament\Resources\ServiceResource;
use App\Jobs\OptimizeServiceImages;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Cache;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;

    protected function afterCreate(): void
    {
        Cache::delete(ServiceCacheKey::ACTIVE->value);

        // Dispatch image optimization job if images were uploaded
        if ($this->record->image || $this->record->headerImage) {
            OptimizeServiceImages::dispatch($this->record);
        }
    }
}
