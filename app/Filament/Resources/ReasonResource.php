<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReasonResource\Pages;
use App\Models\Reason;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReasonResource extends Resource
{
    protected static ?string $model = Reason::class;

    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';

    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.reason.plural_label');
    }

    public static function getModelLabel(): string
    {
        return __('filament.resources.reason.singular_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__('filament.labels.title'))
                    ->required(),
                RichEditor::make('description')
                    ->label(__('filament.labels.description'))
                    ->required()
                    ->columnSpan('full')
                    ->extraInputAttributes(['class' => 'max-h-96', 'style' => 'overflow-y: scroll;']),
                FileUpload::make('image')
                    ->label(__('filament.labels.image'))
                    ->image()
                    ->disk('public')
                    ->directory('reasons')
                    ->visibility('public'),
                KeyValue::make('attachments')
                    ->label(__('filament.labels.attachments')),
                Forms\Components\Toggle::make('isActive')
                    ->label(__('filament.labels.isActive'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label(__('filament.labels.image')),
                TextColumn::make('title')
                    ->label(__('filament.labels.title'))
                    ->searchable(),
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
            'index' => Pages\ListReasons::route('/'),
            'create' => Pages\CreateReason::route('/create'),
            'edit' => Pages\EditReason::route('/{record}/edit'),
        ];
    }
}
