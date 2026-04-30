<?php

namespace App\Filament\Blocks;

use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class ButtonBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'button';
    }

    public static function getLabel(): string
    {
        return 'Button Link';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription(__('filament.modals.configure_button_link'))
            ->modalWidth('lg')
            ->schema([
                TextInput::make('text')
                    ->label(__('filament.labels.button_text'))
                    ->placeholder(__('filament.placeholders.button_text'))
                    ->required(),
                TextInput::make('url')
                    ->label(__('filament.labels.button_url'))
                    ->placeholder(__('filament.placeholders.button_url'))
                    ->required()
                    ->rules(['regex:/^(https?:\/\/|tel:|\/).+/']),
                Select::make('target')
                    ->label(__('filament.labels.target'))
                    ->options([
                        '_self' => __('filament.options.target._self'),
                        '_blank' => __('filament.options.target._blank'),
                    ])
                    ->default('_self')
                    ->helperText(__('filament.helpers.target')),
            ]);
    }

    public static function getPreviewLabel(array $config): string
    {
        $text = $config['text'] ?? '';

        if ($text) {
            return "Button: {$text}";
        }

        return 'Button Link';
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
        $text = e($config['text'] ?? $data['text'] ?? '');
        $url = e($config['url'] ?? $data['url'] ?? '#');
        $target = e($config['target'] ?? $data['target'] ?? '_self');
        $relAttr = $target === '_blank' ? 'rel="noopener noreferrer"' : '';

        return <<<HTML
            <div class="custom-button-wrapper" data-button="true">
                <a href="{$url}"
                   class="inline-flex items-center justify-center px-4 py-2 bg-mint-600 text-white font-medium rounded-full hover:bg-mint-700 focus:outline-none focus:ring-2 focus:ring-mint-500 focus:ring-offset-2 transition-colors duration-200"
                   target="{$target}"
                   {$relAttr}>
                    {$text}
                </a>
            </div>
        HTML;
    }
}
