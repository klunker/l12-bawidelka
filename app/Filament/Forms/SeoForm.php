<?php

namespace App\Filament\Forms;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class SeoForm
{
    public static function make(): Section
    {
        return Section::make(__('filament.sections.seo_metadata'))
            ->relationship('seoMeta')
            ->schema([
                TextInput::make('title')
                    ->label(__('filament.labels.seo_title'))
                    ->maxLength(255),
                Textarea::make('description')
                    ->label(__('filament.labels.seo_description'))
                    ->maxLength(500),
                TextInput::make('keywords')
                    ->label(__('filament.labels.keywords'))
                    ->maxLength(255),
                TextInput::make('og_title')
                    ->label(__('filament.labels.og_title'))
                    ->maxLength(255),
                Textarea::make('og_description')
                    ->label(__('filament.labels.og_description'))
                    ->maxLength(500),
                FileUpload::make('og_image')
                    ->label(__('filament.labels.og_image'))
                    ->image()
                    ->disk('public')
                    ->directory('seo')
                    ->visibility('public'),
            ])
            ->collapsible();
    }
}
