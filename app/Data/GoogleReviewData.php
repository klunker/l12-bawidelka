<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class GoogleReviewData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly string $author_name,
        public readonly string $author_url,
        public readonly string $profile_photo_url,
        public readonly int $rating,
        public readonly string $text,
        public readonly string $language,
        public readonly string $original_language,
        public readonly bool $translated,
        public readonly string $relative_time_description,
        public readonly int $time,
        public readonly bool $is_active,
    ) {}
}
