<?php

namespace Database\Factories;

use App\Models\GoogleReview;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class GoogleReviewFactory extends Factory
{
    protected $model = GoogleReview::class;

    public function definition(): array
    {
        return [
            'author_name' => $this->faker->name(),
            'author_url' => $this->faker->url(),
            'profile_photo_url' => $this->faker->url(),
            'rating' => $this->faker->randomNumber(),
            'text' => $this->faker->text(),
            'language' => $this->faker->word(),
            'original_language' => $this->faker->word(),
            'translated' => $this->faker->boolean(),
            'relative_time_description' => $this->faker->text(),
            'time' => $this->faker->randomNumber(),
            'is_active' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
