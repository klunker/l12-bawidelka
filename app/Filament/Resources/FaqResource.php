<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaqResource\Pages;
use App\Models\Faq;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.faq.plural_label');
    }

    public static function getModelLabel(): string
    {
        return __('filament.resources.faq.singular_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('question')
                    ->label(__('filament.labels.question'))
                    ->required(),
                RichEditor::make('answer')
                    ->label(__('filament.labels.answer'))
                    ->required()
                    ->columnSpan('full')
                    ->extraInputAttributes(['class' => 'max-h-96', 'style' => 'overflow-y: scroll;']),
                Forms\Components\Toggle::make('isActive')
                    ->label(__('filament.labels.isActive'))
                    ->required(),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->label(__('filament.labels.sort_order')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question')
                    ->label(__('filament.labels.question'))
                    ->searchable(),
                TextColumn::make('sort_order')
                    ->label(__('filament.labels.sort_order'))
                    ->numeric()
                    ->sortable(),
                BooleanColumn::make('isActive')
                    ->label(__('filament.labels.isActive')),
            ])
            ->defaultSort('sort_order', 'asc')
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
            'index' => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit' => Pages\EditFaq::route('/{record}/edit'),
        ];
    }
}
