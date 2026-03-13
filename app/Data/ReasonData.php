<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class ReasonData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $description,
        public readonly ?string $image,
        public readonly ?string $image_url,
        /** @var array<mixed> */
        public readonly array $attachments,
        public readonly bool $isActive,
    ) {}
}
