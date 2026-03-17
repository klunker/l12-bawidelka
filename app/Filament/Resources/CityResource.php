<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CityResource\Pages;
use App\Models\City;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
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

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-office';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('filament.sections.general_info'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('filament.labels.name'))
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('title')
                            ->label(__('filament.labels.branch_name')),
                        TextInput::make('address')
                            ->label(__('filament.labels.address')),
                        TextInput::make('postal_code')
                            ->label(__('filament.labels.postal_code')),
                        TextInput::make('phone')
                            ->label(__('filament.labels.phone')),
                        TextInput::make('nip')
                            ->label(__('filament.labels.nip'))
                            ->mask('999-999-99-99'),
                        TextInput::make('regon')
                            ->label(__('filament.labels.regon'))
                            ->minLength(9)->maxLength(14),
                        Toggle::make('active')
                            ->label(__('filament.labels.isActive'))
                            ->required(),
                    ]),
                Section::make(__('filament.sections.social_networks'))
                    ->schema([
                        TextInput::make('facebook')
                            ->label(__('filament.labels.facebook'))
                            ->url()
                            ->prefixIcon('heroicon-o-link')
                            ->placeholder(__('filament.placeholders.facebook')),
                        TextInput::make('instagram')
                            ->label(__('filament.labels.instagram'))
                            ->url()
                            ->prefixIcon('heroicon-o-camera')
                            ->placeholder(__('filament.placeholders.instagram')),
                    ])->collapsible(),
            ])->columns(1);
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
                IconColumn::make('active')
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
            'index' => Pages\ListCities::route('/'),
            'create' => Pages\CreateCity::route('/create'),
            'edit' => Pages\EditCity::route('/{record}/edit'),
        ];
    }
}
