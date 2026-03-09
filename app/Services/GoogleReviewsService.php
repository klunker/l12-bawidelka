<?php

namespace App\Services;

use App\Enums\GoogleReviewsCacheKey;
use App\Models\GoogleReview;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleReviewsService
{
    protected ?string $apiKey;

    protected ?string $placeId;

    public function __construct()
    {
        $this->apiKey = config('services.google.places_api_key');
        $this->placeId = config('services.google.place_id');
    }

    public function fetchAndStoreReviews(): int|false
    {
        if (! $this->apiKey || ! $this->placeId) {
            Log::error('Google Places API Key or Place ID is missing.');

            return false;
        }

        $url = "https://maps.googleapis.com/maps/api/place/details/json?place_id={$this->placeId}&fields=reviews&key={$this->apiKey}&language=pl";

        try {
            $response = Http::get($url);

            if ($response->failed()) {
                Log::error('Failed to fetch Google Reviews: '.$response->body());

                return false;
            }

            $data = $response->json();

            if ($data['status'] !== 'OK') {
                Log::error('Google Places API Error: '.($data['error_message'] ?? $data['status']));

                return false;
            }

            $reviews = $data['result']['reviews'] ?? [];
            $count = 0;

            foreach ($reviews as $review) {
                GoogleReview::updateOrCreate(
                    [
                        'author_name' => $review['author_name'],
                        'time' => $review['time'],
                    ],
                    [
                        'author_url' => $review['author_url'] ?? null,
                        'profile_photo_url' => $review['profile_photo_url'] ?? null,
                        'rating' => $review['rating'],
                        'text' => $review['text'] ?? null,
                        'language' => $review['language'] ?? null,
                        'original_language' => $review['original_language'] ?? null,
                        'translated' => $review['translated'] ?? false,
                        'relative_time_description' => $review['relative_time_description'] ?? null,
                        'is_active' => true, // Default to active
                    ]
                );
                $count++;
            }

            Cache::forget(GoogleReviewsCacheKey::ACTIVE->value);

            return $count;

        } catch (\Exception $e) {
            Log::error('Exception fetching Google Reviews: '.$e->getMessage());

            return false;
        }
    }

    /**
     * Get active Google reviews.
     *
     * @return Collection<int, GoogleReview>
     */
    public function getActiveReviews(): Collection
    {
        return GoogleReview::active()->orderBy('time', 'desc')->get();
    }
}
