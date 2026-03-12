<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityResource\Pages;
use App\Models\Activity;
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
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-sparkles';

    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.activity.plural_label');
    }

    public static function getModelLabel(): string
    {
        return __('filament.resources.activity.singular_label');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Grid::make(3)
                    ->schema([
                        Section::make(__('filament.sections.general_info'))
                            ->columnSpan(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('filament.labels.name'))
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (
                                        string $operation,
                                        $state,
                                        Set $set
                                    ) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                                TextInput::make('slug')
                                    ->label(__('filament.labels.slug'))
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->helperText('Slug will be auto-generated from name'),
                                TextInput::make('badge')
                                    ->label(__('filament.labels.badge')),
                                Select::make('color')
                                    ->label(__('filament.labels.color'))
                                    ->options([
                                        'default' => __('filament.options.color.default'),
                                        'mint' => __('filament.options.color.mint'),
                                        'brown' => __('filament.options.color.brown'),
                                        'pink-pounder' => __('filament.options.color.pink_pounder'),
                                        'peach' => __('filament.options.color.peach'),
                                        'pistachio' => __('filament.options.color.pistachio'),
                                        'lavender' => __('filament.options.color.lavender'),
                                    ])
                                    ->required()
                                    ->native(false),
                                Toggle::make('isActive')
                                    ->label(__('filament.labels.isActive'))
                                    ->required(),
                            ]),

                        Section::make(__('filament.sections.media_relations'))
                            ->columnSpan(1)
                            ->schema([
                                FileUpload::make('image')
                                    ->label(__('filament.labels.image'))
                                    ->image()
                                    ->acceptedFileTypes(['image/*'])
                                    ->required()
                                    ->disk('public')
                                    ->directory('activities')
                                    ->visibility('public'),
                                Select::make('cities')
                                    ->label(__('filament.labels.cities'))
                                    ->multiple()
                                    ->relationship('cities', 'name')
                                    ->preload(),
                            ]),
                    ]),
                Grid::make(3)
                    ->schema([
                        Section::make(__('filament.sections.schedule'))
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('duration')
                                            ->label(__('filament.labels.duration'))
                                            ->required()
                                            ->integer()
                                            ->suffix('min'),
                                        TextInput::make('order')
                                            ->label(__('filament.labels.order'))
                                            ->required()
                                            ->integer(),
                                    ]),
                            ]),

                        Section::make(__('filament.sections.pricing'))
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextInput::make('price')
                                            ->label(__('filament.labels.price'))
                                            ->required()
                                            ->numeric()
                                            ->prefix('PLN'),
                                        TextInput::make('weekendPrice')
                                            ->label(__('filament.labels.weekend_price'))
                                            ->required()
                                            ->numeric()
                                            ->prefix('PLN'),
                                        TextInput::make('extra_price')
                                            ->label(__('filament.labels.extra_price'))
                                            ->nullable()
                                            ->numeric()
                                            ->prefix('PLN'),
                                    ]),
                            ]),

                        Section::make(__('filament.sections.age_capacity'))
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('ageFrom')
                                            ->label(__('filament.labels.age_from'))
                                            ->required()
                                            ->integer(),
                                        TextInput::make('ageTo')
                                            ->label(__('filament.labels.age_to'))
                                            ->required()
                                            ->integer(),
                                        TextInput::make('numChildren')
                                            ->label(__('filament.labels.num_children'))
                                            ->required()
                                            ->integer(),
                                        TextInput::make('maxChildren')
                                            ->label(__('filament.labels.max_children'))
                                            ->required()
                                            ->integer(),
                                    ]),
                            ]),
                    ]),

                Section::make(__('filament.sections.content'))
                    ->schema([
                        RichEditor::make('description')
                            ->label(__('filament.labels.description'))
                            ->nullable()
                            ->columnSpan('full')
                            ->extraInputAttributes(['class' => 'max-h-96', 'style' => 'overflow-y: scroll;']),
                        Repeater::make('features')
                            ->label(__('filament.labels.features'))
                            ->simple(
                                TextInput::make('value')
                                    ->hiddenLabel()
                                    ->required(),
                            )
                            ->addActionLabel(__('filament.labels.add_feature'))
                            ->reorderableWithButtons(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->square()
                    ->label(__('filament.labels.image')),
                TextColumn::make('name')
                    ->label(__('filament.labels.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('color')
                    ->label(__('filament.labels.color'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'mint' => 'success',
                        'brown' => 'warning',
                        'pink-pounder' => 'danger',
                        'peach' => 'warning',
                        'pistachio' => 'success',
                        'lavender' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => __("filament.options.color.{$state}")),
                TextColumn::make('order')
                    ->label(__('filament.labels.order'))
                    ->sortable(),
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
            'index' => Pages\ListActivities::route('/'),
            'create' => Pages\CreateActivity::route('/create'),
            'edit' => Pages\EditActivity::route('/{record}/edit'),
        ];
    }
}
