<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GoogleReviewResource\Pages;
use App\Models\GoogleReview;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GoogleReviewResource extends Resource
{
    protected static ?string $model = GoogleReview::class;

    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.google_review.plural_label');
    }

    public static function getModelLabel(): string
    {
        return __('filament.resources.google_review.singular_label');
    }

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-star';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('author_name')
                    ->label(__('filament.labels.author_name'))
                    ->required(),
                TextInput::make('rating')
                    ->label(__('filament.labels.rating'))
                    ->numeric()
                    ->required(),
                Textarea::make('text')
                    ->label(__('filament.labels.text'))
                    ->columnSpan('full'),
                Toggle::make('is_active')
                    ->label(__('filament.labels.isActive'))
                    ->required(),
                TextInput::make('relative_time_description')
                    ->label(__('filament.labels.relative_time')),
                TextInput::make('time')
                    ->label(__('filament.labels.time'))
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile_photo_url')
                    ->label(__('filament.labels.image'))
                    ->circular(),
                TextColumn::make('author_name')
                    ->label(__('filament.labels.author_name'))
                    ->searchable(),
                TextColumn::make('rating')
                    ->label(__('filament.labels.rating'))
                    ->sortable(),
                TextColumn::make('text')
                    ->label(__('filament.labels.text'))
                    ->limit(50),
                TextColumn::make('relative_time_description')
                    ->label(__('filament.labels.relative_time')),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label(__('filament.labels.isActive')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGoogleReviews::route('/'),
            'create' => Pages\CreateGoogleReview::route('/create'),
            'edit' => Pages\EditGoogleReview::route('/{record}/edit'),
        ];
    }
}
