<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GoogleReviewResource\Pages;
use App\Models\GoogleReview;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
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

    protected static ?string $navigationIcon = 'heroicon-o-star';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('author_name')
                    ->label(__('filament.labels.author_name'))
                    ->required(),
                Forms\Components\TextInput::make('rating')
                    ->label(__('filament.labels.rating'))
                    ->numeric()
                    ->required(),
                Forms\Components\Textarea::make('text')
                    ->label(__('filament.labels.text'))
                    ->columnSpan('full'),
                Forms\Components\Toggle::make('is_active')
                    ->label(__('filament.labels.isActive'))
                    ->required(),
                Forms\Components\TextInput::make('relative_time_description')
                    ->label(__('filament.labels.relative_time')),
                Forms\Components\TextInput::make('time')
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
                BooleanColumn::make('is_active')
                    ->label(__('filament.labels.isActive')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
