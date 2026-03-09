<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Enums\ServiceCacheKey;
use App\Filament\Resources\ServiceResource;
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
    }
}
