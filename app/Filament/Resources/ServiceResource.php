<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.service.plural_label');
    }

    public static function getModelLabel(): string
    {
        return __('filament.resources.service.singular_label');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
                // Row 1: Main info and media
                Grid::make(2)
                    ->schema([
                        Section::make(__('filament.sections.general_info'))
                            ->columnSpan(1)
                            ->schema([
                                TextInput::make('title')
                                    ->label(__('filament.labels.title'))
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $state, callable $set) {
                                        $set('slug', Str::slug($state));
                                    }),
                                TextInput::make('slug')
                                    ->label(__('filament.labels.slug'))
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->hidden(fn (string $operation): bool => $operation === 'create'),
                                TextInput::make('sub_title')
                                    ->label(__('filament.labels.sub_title'))
                                    ->nullable()
                                    ->maxLength(255),
                                Toggle::make('isActive')
                                    ->label(__('filament.labels.isActive'))
                                    ->required()
                                    ->inline(false),
                                TextInput::make('sort_order')
                                    ->label(__('filament.labels.sort_order'))
                                    ->numeric()
                                    ->default(0),
                            ]),

                        Section::make(__('filament.sections.media_relations'))
                            ->columnSpan(1)
                            ->schema([
                                Select::make('template')
                                    ->label(__('filament.labels.template'))
                                    ->options([
                                        'standard' => __('filament.options.template.standard'),
                                        'special' => __('filament.options.template.special'),
                                        'urodzinki' => __('filament.options.template.urodzinki'),
                                    ])
                                    ->required()
                                    ->native(false)
                                    ->live(),
                                FileUpload::make('image')
                                    ->label(__('filament.labels.image'))
                                    ->image()
                                    ->acceptedFileTypes(['image/*'])
                                    ->required()
                                    ->disk('public')
                                    ->directory('services')
                                    ->visibility('public'),
                                FileUpload::make('headerImage')
                                    ->label(__('filament.labels.header_image'))
                                    ->image()
                                    ->acceptedFileTypes(['image/*'])
                                    ->nullable()
                                    ->disk('public')
                                    ->directory('services/headers')
                                    ->visibility('public'),
                                Select::make('cities')
                                    ->label(__('filament.labels.cities'))
                                    ->multiple()
                                    ->relationship('cities', 'name')
                                    ->preload()
                                    ->searchable(),
                            ]),
                    ]),
                // Row 2: Content
                Section::make(__('filament.sections.content'))
                    ->collapsible()
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                RichEditor::make('description')
                                    ->label(__('filament.labels.description'))
                                    ->required()
                                    ->columnSpan(1),
                                RichEditor::make('description_additional')
                                    ->label(__('filament.labels.description_additional'))
                                    ->nullable()
                                    ->columnSpan(1)
                                    ->visible(fn (callable $get) => $get('template') === 'urodzinki'),
                            ]),
                    ]),

                // Row 3: Additional details (only for urodzinki)
                Section::make(__('filament.sections.additional_details'))
                    ->collapsible()
                    ->visible(fn (callable $get) => $get('template') === 'urodzinki')
                    ->schema([
                        Repeater::make('options')
                            ->label(__('filament.labels.options'))
                            ->simple(
                                TextInput::make('value')
                                    ->hiddenLabel()
                                    ->required(),
                            )
                            ->addActionLabel(__('filament.labels.add_option'))
                            ->reorderableWithButtons()
                            ->collapsible(),

                        Repeater::make('attachments')
                            ->label(__('filament.labels.attachments'))
                            ->schema([
                                FileUpload::make('file')
                                    ->required()
                                    ->disk('public')
                                    ->directory('service_attachments')
                                    ->visibility('public')
                                    ->downloadable()
                                    ->label(__('filament.labels.file'))
                                    ->columnSpan(1),
                                TextInput::make('name')
                                    ->required()
                                    ->label(__('filament.labels.file_name'))
                                    ->columnSpan(3),
                            ])
                            ->columns(4)
                            ->addActionLabel(__('filament.labels.add_attachment'))
                            ->reorderableWithButtons()
                            ->collapsible(),
                    ]),
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
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->label(__('filament.labels.slug'))
                    ->searchable(),
                TextColumn::make('template')
                    ->label(__('filament.labels.template'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'standard' => 'gray',
                        'special' => 'warning',
                        'urodzinki' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => __("filament.options.template.{$state}")),
                TextColumn::make('sort_order')
                    ->label(__('filament.labels.sort_order'))
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('isActive')
                    ->boolean()
                    ->label(__('filament.labels.isActive'))
                    ->sortable(),
            ])
            ->defaultSort('sort_order', 'asc')
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
