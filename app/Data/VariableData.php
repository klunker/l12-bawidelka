<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class VariableData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly string $key,
        public readonly string $value,
        public readonly ?string $description,
    ) {}
}
