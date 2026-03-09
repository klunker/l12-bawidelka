<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.service.plural_label');
    }

    public static function getModelLabel(): string
    {
        return __('filament.resources.service.singular_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Section::make(__('filament.sections.general_info'))
                            ->columnSpan(2)
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label(__('filament.labels.title'))
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (
                                        string $operation,
                                        $state,
                                        Forms\Set $set
                                    ) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                                Forms\Components\TextInput::make('slug')
                                    ->label(__('filament.labels.slug'))
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->hidden(fn (string $operation): bool => $operation === 'create'),
                                Forms\Components\TextInput::make('sub_title')
                                    ->label(__('filament.labels.sub_title'))
                                    ->nullable()
                                    ->maxLength(255),
                                Forms\Components\Toggle::make('isActive')
                                    ->label(__('filament.labels.isActive'))
                                    ->required()
                                    ->inline(false),
                                Forms\Components\TextInput::make('sort_order')
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
                                Forms\Components\Select::make('cities')
                                    ->label(__('filament.labels.cities'))
                                    ->multiple()
                                    ->relationship('cities', 'name')
                                    ->preload()
                                    ->searchable(),
                            ]),
                    ]),

                Section::make(__('filament.sections.content'))
                    ->schema([
                        RichEditor::make('description')
                            ->label(__('filament.labels.description'))
                            ->required()
                            ->columnSpan('full')
                            ->extraInputAttributes(['class' => 'max-h-96', 'style' => 'overflow-y: scroll;']),
                        RichEditor::make('description_additional')
                            ->label(__('filament.labels.description_additional'))
                            ->nullable()
                            ->columnSpan('full')
                            ->extraInputAttributes(['class' => 'max-h-96', 'style' => 'overflow-y: scroll;'])
                            ->visible(fn (callable $get) => $get('template') === 'urodzinki'),
                    ]),

                Section::make(__('filament.sections.additional_details'))
                    ->schema([
                        Repeater::make('options')
                            ->label(__('filament.labels.options'))
                            ->simple(
                                Forms\Components\TextInput::make('value')
                                    ->hiddenLabel()
                                    ->required(),
                            )
                            ->addActionLabel(__('filament.labels.add_option'))
                            ->reorderableWithButtons(),

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
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->label(__('filament.labels.file_name'))
                                    ->columnSpan(3),

                            ])
                            ->columns(4)
                            ->addActionLabel(__('filament.labels.add_attachment'))
                            ->reorderableWithButtons()
                            ->collapsible(),
                    ])->collapsible()
                    ->visible(fn (callable $get) => $get('template') === 'urodzinki'),
                \App\Filament\Forms\SeoForm::make()
                    ->columnSpan(2),
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
                BooleanColumn::make('isActive')
                    ->label(__('filament.labels.isActive'))
                    ->sortable(),
            ])
            ->defaultSort('sort_order', 'asc')
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
