<?php

namespace App\Data;

use App\Data\SeoMetaData;
use Spatie\LaravelData\Data;

class PageData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly string $slug,
        public readonly string $title,
        public readonly string $content,
        public readonly bool $is_active,
        public readonly ?SeoMetaData $seo_meta = null,
    ) {}
}
