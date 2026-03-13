<?php

namespace App\Data;

use App\Data\CityData as DataCity;
use App\Data\SeoMetaData;
use Spatie\LaravelData\Data;

class ServiceData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly string $slug,
        public readonly string $title,
        public readonly ?string $sub_title,
        public readonly string $description,
        public readonly ?string $description_additional,
        public readonly ?string $image,
        public readonly ?string $image_url,
        public readonly ?string $headerImage,
        public readonly ?string $header_image_url,
        public readonly ?string $template,
        /** @var array<mixed> */
        public readonly array $options,
        /** @var array<mixed> */
        public readonly array $attachments,
        /** @var array<string, string> */
        public readonly array $attachments_urls,
        public readonly bool $isActive,
        public readonly int $sort_order,
        /** @var array<DataCity> */
        public readonly array $cities = [],
        public readonly ?SeoMetaData $seo_meta = null,
    ) {}
}
