<?php

namespace App\Filament\Resources\GoogleReviewResource\Pages;

use App\Filament\Resources\GoogleReviewResource;
use App\Services\GoogleReviewsService;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListGoogleReviews extends ListRecords
{
    protected static string $resource = GoogleReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('syncReviews')
                ->label('Sync Google Reviews')
                ->icon('heroicon-o-arrow-path')
                ->action(function () {
                    $service = app(GoogleReviewsService::class);
                    $count = $service->fetchAndStoreReviews();

                    if ($count !== false) {
                        Notification::make()
                            ->title('Reviews Synced')
                            ->body("Successfully synced {$count} reviews.")
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Sync Failed')
                            ->body('Failed to sync reviews. Check logs for details.')
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }
}
