<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CityResource\Pages;
use App\Models\City;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CityResource extends Resource
{
    protected static ?string $model = City::class;

    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.city.plural_label');
    }

    public static function getModelLabel(): string
    {
        return __('filament.resources.city.singular_label');
    }

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('filament.sections.general_info'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('filament.labels.name'))
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('title')
                            ->label(__('filament.labels.branch_name')),
                        Forms\Components\TextInput::make('address')
                            ->label(__('filament.labels.address')),
                        Forms\Components\TextInput::make('postal_code')
                            ->label(__('filament.labels.postal_code')),
                        Forms\Components\TextInput::make('phone')
                            ->label(__('filament.labels.phone')),
                        Forms\Components\TextInput::make('nip')
                            ->label(__('filament.labels.nip'))
                            ->mask('999-999-99-99'),
                        Forms\Components\TextInput::make('regon')
                            ->label(__('filament.labels.regon'))
                            ->minLength(9)->maxLength(14),
                        Forms\Components\Toggle::make('active')
                            ->label(__('filament.labels.isActive'))
                            ->required(),
                    ]),
                Section::make(__('filament.sections.social_networks'))
                    ->schema([
                        Forms\Components\TextInput::make('facebook')
                            ->label(__('filament.labels.facebook'))
                            ->url()
                            ->prefixIcon('heroicon-o-link')
                            ->placeholder(__('filament.placeholders.facebook')),
                        Forms\Components\TextInput::make('instagram')
                            ->label(__('filament.labels.instagram'))
                            ->url()
                            ->prefixIcon('heroicon-o-camera')
                            ->placeholder(__('filament.placeholders.instagram')),
                    ])->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('filament.labels.name'))
                    ->searchable(),
                TextColumn::make('title')
                    ->label(__('filament.labels.branch_name'))
                    ->searchable(),
                TextColumn::make('address')
                    ->label(__('filament.labels.address')),
                TextColumn::make('phone')
                    ->label(__('filament.labels.phone')),
                TextColumn::make('nip')
                    ->label(__('filament.labels.nip')),
                TextColumn::make('regon')
                    ->label(__('filament.labels.regon')),
                BooleanColumn::make('active')
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
            'index' => Pages\ListCities::route('/'),
            'create' => Pages\CreateCity::route('/create'),
            'edit' => Pages\EditCity::route('/{record}/edit'),
        ];
    }
}
