<?php

namespace App\Filament\Resources\ReasonResource\Pages;

use App\Filament\Resources\ReasonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditReason extends EditRecord
{
    protected static string $resource = ReasonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $record = $this->getRecord();

        if ($record->hasAttribute('image') && $record->getAttributeValue('image') !== $data['image']) {
            if (Storage::disk('public')->exists($record->getAttributeValue('image'))) {
                Storage::disk('public')->delete($record->getAttributeValue('image'));
            }
        }

        return $data;
    }
}
