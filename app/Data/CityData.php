<?php

namespace App\Data;

use App\Data\ServiceData as DataService;
use App\Data\ActivityData as DataActivity;
use Spatie\LaravelData\Data;

class CityData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $title,
        public readonly string $address,
        public readonly string $postal_code,
        public readonly string $phone,
        public readonly ?string $facebook,
        public readonly ?string $instagram,
        public readonly bool $active,
        public readonly ?string $nip,
        public readonly ?string $regon,
        /** @var array<DataService> */
        public readonly array $services = [],
        /** @var array<DataActivity> */
        public readonly array $activities = [],
    ) {}
}
