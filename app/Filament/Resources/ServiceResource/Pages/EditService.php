<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Enums\ServiceCacheKey;
use App\Filament\Resources\ServiceResource;
use App\Jobs\OptimizeServiceImages;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Cache;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        Cache::delete(ServiceCacheKey::ACTIVE->value);
        Cache::delete(ServiceCacheKey::SINGLE->value.$this->record->getAttributeValue('slug'));

        // Dispatch image optimization job if images were uploaded
        if ($this->record->image || $this->record->headerImage) {
            OptimizeServiceImages::dispatch($this->record);
        }
    }
}
