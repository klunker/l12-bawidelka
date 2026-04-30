<?php

namespace App\Filament\Resources;

use App\Filament\Blocks\ButtonBlock;
use App\Filament\Blocks\TlistBlock;
use App\Filament\Resources\ReasonResource\Pages;
use App\Models\Reason;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReasonResource extends Resource
{
    protected static ?string $model = Reason::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-light-bulb';

    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.reason.plural_label');
    }

    public static function getModelLabel(): string
    {
        return __('filament.resources.reason.singular_label');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('filament.sections.general_info'))
                    ->schema([
                        TextInput::make('title')
                            ->label(__('filament.labels.title'))
                            ->required(),
                        Toggle::make('isActive')
                            ->label(__('filament.labels.isActive'))
                            ->required(),
                    ]),

                Section::make(__('filament.sections.content'))
                    ->schema([
                        RichEditor::make('description')
                            ->label(__('filament.labels.description'))
                            ->required()
                            ->columnSpan('full')
                            ->customBlocks([TlistBlock::class, ButtonBlock::class])
                            ->extraInputAttributes(['class' => 'max-h-96', 'style' => 'overflow-y: scroll;']),
                    ]),

                Section::make(__('filament.sections.media'))
                    ->schema([
                        FileUpload::make('image')
                            ->label(__('filament.labels.image'))
                            ->image()
                            ->disk('public')
                            ->directory('reasons')
                            ->visibility('public'),
                        KeyValue::make('attachments')
                            ->label(__('filament.labels.attachments')),
                    ]),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('filament.labels.title'))
                    ->searchable(),
                IconColumn::make('isActive')
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
            'index' => Pages\ListReasons::route('/'),
            'create' => Pages\CreateReason::route('/create'),
            'edit' => Pages\EditReason::route('/{record}/edit'),
        ];
    }
}
