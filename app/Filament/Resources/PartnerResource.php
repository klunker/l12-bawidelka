<?php

namespace App\Filament\Resources;

use App\Filament\Blocks\TlistBlock;
use App\Filament\Blocks\ButtonBlock;
use App\Filament\Resources\PartnerResource\Pages;
use App\Models\Partner;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.partner.plural_label');
    }

    public static function getModelLabel(): string
    {
        return __('filament.resources.partner.singular_label');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('filament.sections.general_info'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('filament.labels.name'))
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                        TextInput::make('slug')
                            ->label(__('filament.labels.slug'))
                            ->required()
                            ->unique(Partner::class, 'slug', ignoreRecord: true)
                            ->alphaDash()
                            ->hidden(fn (string $operation): bool => $operation === 'create'),
                        Toggle::make('isActive')
                            ->label(__('filament.labels.isActive'))
                            ->required()
                            ->default(true),
                        TextInput::make('order')
                            ->label(__('filament.labels.order'))
                            ->numeric()
                            ->default(0),
                    ]),

                Section::make(__('filament.sections.media'))
                    ->schema([
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

                    ]),

                Section::make(__('filament.sections.content'))
                    ->schema([
                        RichEditor::make('description')
                            ->label(__('filament.labels.description'))
                            ->columnSpanFull()
                            ->customBlocks([TlistBlock::class, ButtonBlock::class])
                            ->extraInputAttributes(['class' => 'max-h-96', 'style' => 'overflow-y: scroll;']),
                        TextInput::make('url')
                            ->label(__('filament.labels.url'))
                            ->url(),
                    ]),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('filament.labels.name'))
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
            'index' => Pages\ListPartners::route('/'),
            'create' => Pages\CreatePartner::route('/create'),
            'edit' => Pages\EditPartner::route('/{record}/edit'),
        ];
    }
}
