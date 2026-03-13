<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class SeoMetaData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly int $seoable_id,
        public readonly string $seoable_type,
        public readonly ?string $title,
        public readonly ?string $description,
        public readonly ?string $keywords,
        public readonly ?string $og_title,
        public readonly ?string $og_description,
        public readonly ?string $og_image,
    ) {}
}
