<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class PartnerData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $slug,
        public readonly ?string $logo,
        public readonly ?string $photo,
        public readonly ?string $url,
        public readonly string $description,
        public readonly bool $isActive,
        public readonly int $order,
        public readonly ?string $logo_url,
        public readonly ?string $photo_url,
    ) {}
}
