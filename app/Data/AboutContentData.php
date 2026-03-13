<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class AboutContentData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly string $content,
        public readonly bool $isActive,
    ) {}
}
