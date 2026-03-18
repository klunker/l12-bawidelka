<?php

namespace App\Filament\Blocks;

use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\TextInput;

class TlistBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'tlist';
    }

    public static function getLabel(): string
    {
        return 'Custom List';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Configure the custom list block')
            ->modalWidth('lg')
            ->schema([
                TextInput::make('title')
                    ->label('Heading')
                    ->placeholder('Enter list heading...')
                    ->required(),
                Repeater::make('items')
                    ->label('List items')
                    ->simple(
                        TextInput::make('item')
                            ->placeholder('Enter list item...')
                            ->hiddenLabel(),
                    )
                    ->addActionLabel('Add item')
                    ->defaultItems(1)
                    ->minItems(1),
            ]);
    }

    public static function getPreviewLabel(array $config): string
    {
        $title = $config['title'] ?? '';

        if ($title) {
            return "Custom List: {$title}";
        }

        return 'Custom List';
    }

    public static function toPreviewHtml(array $config): string
    {
        return static::toHtml($config, []);
    }

    /**
     * @param  array<string, mixed>  $config
     * @param  array<string, mixed>  $data
     */
    public static function toHtml(array $config, array $data): string
    {
        $title = e($config['title'] ?? '');

        $items = $config['items'] ?? $data['items'] ?? [];

        $itemsHtml = '';

        if (is_array($items) && ! empty($items)) {
            // Simple Repeater stores values directly or as objects
            $itemsHtml = collect($items)
                ->map(function ($item) {
                    // If item is a string, use it directly
                    if (is_string($item)) {
                        return '<li>'.e(trim($item)).'</li>';
                    }
                    // If item is an array/object with 'item' key
                    if (is_array($item) && isset($item['item'])) {
                        return '<li>'.e(trim($item['item'])).'</li>';
                    }
                    // If item is an object with 'item' property
                    if (is_object($item) && isset($item->item)) {
                        return '<li>'.e(trim($item->item)).'</li>';
                    }

                    return '';
                })
                ->filter()
                ->join('');
        }

        return <<<HTML
            <div class="custom-tlist" data-tlist="true">
                <h3>{$title}</h3>
                <ul>{$itemsHtml}</ul>
            </div>
        HTML;
    }
}
