<?php

namespace App\Filament\Blocks;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;

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
            ->modalDescription('Configure the button link block')
            ->modalWidth('lg')
            ->schema([
                TextInput::make('text')
                    ->label('Button Text')
                    ->placeholder('Enter button text...')
                    ->required(),
                TextInput::make('url')
                    ->label('Button URL')
                    ->placeholder('Enter button URL (e.g., https://example.com or /page)...')
                    ->url()
                    ->required(),
                TextInput::make('target')
                    ->label('Target')
                    ->placeholder('_self or _blank')
                    ->default('_self')
                    ->helperText('_self opens in same tab, _blank opens in new tab'),
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
