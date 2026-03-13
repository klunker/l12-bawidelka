<?php

namespace App\Data;

use App\Data\CityData as DataCity;
use Spatie\LaravelData\Data;

class ActivityData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $slug,
        public readonly string $description,
        public readonly ?string $image,
        public readonly ?string $image_url,
        public readonly float $price,
        public readonly ?float $weekendPrice,
        public readonly string $duration,
        public readonly int $order,
        public readonly int $ageFrom,
        public readonly int $ageTo,
        public readonly int $maxChildren,
        public readonly int $numChildren,
        public readonly ?float $extra_price,
        /** @var array<string> */
        public readonly array $features,
        public readonly ?string $badge,
        public readonly ?string $color,
        public readonly bool $isActive,
        /** @var array<DataCity> */
        public readonly array $cities = [],
    ) {}
}
