<?php

namespace App\Filament\Resources;

use App\Filament\Forms\SeoForm;
use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.page.plural_label');
    }

    public static function getModelLabel(): string
    {
        return __('filament.resources.page.singular_label');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([

                Section::make(__('filament.sections.general_info'))
                    ->columns(1)
                    ->schema([
                        TextInput::make('title')
                            ->label(__('filament.labels.title'))
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true),
                        TextInput::make('slug')
                            ->label(__('filament.labels.slug'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Toggle::make('is_active')
                            ->label(__('filament.labels.isActive'))
                            ->default(true)
                            ->required(),
                    ]),

                Section::make(__('filament.sections.content'))
                    ->schema([
                        RichEditor::make('content')
                            ->label(__('filament.labels.content'))
                            ->required()
                            ->columnSpanFull()
                            ->extraInputAttributes(['class' => 'max-h-96', 'style' => 'overflow-y: scroll;']),
                    ]),
                SeoForm::make()
                    ->columnSpan(1),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('slug')
                    ->label(__('filament.labels.slug'))
                    ->searchable(),
                TextColumn::make('title')
                    ->label(__('filament.labels.title'))
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label(__('filament.labels.isActive'))
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label(__('filament.labels.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('filament.labels.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
