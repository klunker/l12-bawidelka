<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VariableResource\Pages;
use App\Models\Variable;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
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

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-variable';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('filament.sections.general_info'))
                    ->schema([
                        Textarea::make('description')
                            ->label(__('filament.labels.description'))
                            ->disabledOn('edit'),
                        TextInput::make('key')
                            ->label(__('filament.labels.key'))
                            ->disabledOn('edit')
                            ->required()
                            ->unique(ignoreRecord: true),
                    ]),

                Section::make(__('filament.sections.content'))
                    ->schema([
                        Textarea::make('value')
                            ->label(__('filament.labels.value')),
                    ]),
            ])->columns(1);
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
            'index' => Pages\ListVariables::route('/'),
            'create' => Pages\CreateVariable::route('/create'),
            'edit' => Pages\EditVariable::route('/{record}/edit'),
        ];
    }
}
