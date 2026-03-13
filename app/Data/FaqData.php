<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class FaqData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly string $question,
        public readonly string $answer,
        public readonly bool $isActive,
        public readonly int $sort_order,
    ) {}
}
