<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutContentResource\Pages;
use App\Models\AboutContent;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AboutContentResource extends Resource
{
    protected static ?string $model = AboutContent::class;

    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-document-text';

    public static function getNavigationGroup(): string
    {
        return __('filament.navigation.content');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.about_content.plural_label');
    }

    public static function getModelLabel(): string
    {
        return __('filament.resources.about_content.singular_label');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('filament.sections.about_content'))
                    ->schema([
                        RichEditor::make('content')
                            ->label(__('filament.labels.content'))
                            ->required()
                            ->columnSpanFull()
                            ->extraInputAttributes(['class' => 'max-h-96', 'style' => 'overflow-y: scroll;']),
                        Toggle::make('isActive')
                            ->label(__('filament.labels.isActive'))
                            ->default(true),
                    ]),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('filament.labels.id'))
                    ->sortable(),
                TextColumn::make('content')
                    ->label(__('filament.labels.content'))
                    ->limit(50)
                    ->searchable(),
                IconColumn::make('isActive')
                    ->boolean()
                    ->label(__('filament.labels.isActive'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
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
            'index' => Pages\ListAboutContents::route('/'),
            'create' => Pages\CreateAboutContent::route('/create'),
            'edit' => Pages\EditAboutContent::route('/{record}/edit'),
        ];
    }
}
