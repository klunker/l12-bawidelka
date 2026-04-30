<?php

namespace App\Helpers;

use App\Filament\Blocks\ButtonBlock;
use App\Filament\Blocks\TlistBlock;
use Filament\Forms\Components\RichEditor\RichContentRenderer;

class RichContentRendererHelper
{
    public static function render(?string $content): ?string
    {
        if (blank($content)) {
            return $content;
        }

        return RichContentRenderer::make($content)
            ->customBlocks([TlistBlock::class, ButtonBlock::class])
            ->toHtml();
    }
}
