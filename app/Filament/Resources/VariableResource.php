<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VariableResource\Pages;
use App\Models\Variable;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VariableResource extends Resource
{
    protected static ?string $model = Variable::class;

    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.variable.plural_label');
    }

    public static function getModelLabel(): string
    {
        return __('filament.resources.variable.singular_label');
    }

    protected static ?string $navigationIcon = 'heroicon-o-variable';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('description')
                    ->label(__('filament.labels.description'))
                    ->disabledOn('edit'),
                Forms\Components\Textarea::make('value')
                    ->label(__('filament.labels.value')),
                Forms\Components\TextInput::make('key')
                    ->label(__('filament.labels.key'))
                    ->disabledOn('edit')
                    ->required()
                    ->unique(ignoreRecord: true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('description')
                    ->label(__('filament.labels.description'))
                    ->limit(50),
                TextColumn::make('value')
                    ->label(__('filament.labels.value'))
                    ->limit(50),
                TextColumn::make('key')
                    ->label(__('filament.labels.key'))
                    ->searchable(),
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
            'index' => Pages\ListVariables::route('/'),
            'create' => Pages\CreateVariable::route('/create'),
            'edit' => Pages\EditVariable::route('/{record}/edit'),
        ];
    }
}
