<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartnerResource\Pages;
use App\Models\Partner;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.partner.plural_label');
    }

    public static function getModelLabel(): string
    {
        return __('filament.resources.partner.singular_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('filament.labels.name'))
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', \Str::slug($state)) : null),
                Forms\Components\TextInput::make('slug')
                    ->label(__('filament.labels.slug'))
                    ->required()
                    ->unique(Partner::class, 'slug', ignoreRecord: true)
                    ->alphaDash()
                    ->hidden(fn (string $operation): bool => $operation === 'create'),
                FileUpload::make('logo')
                    ->label(__('filament.labels.logo'))
                    ->image()
                    ->required()
                    ->disk('public')
                    ->directory('partners')
                    ->visibility('public'),
                FileUpload::make('photo')
                    ->label(__('filament.labels.photo'))
                    ->image()
                    ->disk('public')
                    ->directory('partners')
                    ->visibility('public'),
                Forms\Components\TextInput::make('url')
                    ->label(__('filament.labels.url'))
                    ->url(),
                Forms\Components\RichEditor::make('description')
                    ->label(__('filament.labels.description'))
                    ->columnSpanFull()
                    ->extraInputAttributes(['class' => 'max-h-96', 'style' => 'overflow-y: scroll;']),
                Forms\Components\TextInput::make('order')
                    ->label(__('filament.labels.order'))
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('isActive')
                    ->label(__('filament.labels.isActive'))
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label(__('filament.labels.logo')),
                ImageColumn::make('photo')
                    ->label(__('filament.labels.photo')),
                TextColumn::make('name')
                    ->label(__('filament.labels.name'))
                    ->searchable(),
                TextColumn::make('slug')
                    ->label(__('filament.labels.slug'))
                    ->searchable(),
                TextColumn::make('url')
                    ->label(__('filament.labels.url')),
                TextColumn::make('order')
                    ->label(__('filament.labels.order'))
                    ->sortable(),
                BooleanColumn::make('isActive')
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
            'index' => Pages\ListPartners::route('/'),
            'create' => Pages\CreatePartner::route('/create'),
            'edit' => Pages\EditPartner::route('/{record}/edit'),
        ];
    }
}
