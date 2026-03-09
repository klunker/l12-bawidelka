<?php

namespace Database\Factories;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->text(),
            'image' => $this->faker->word(),
            'price' => $this->faker->randomFloat(),
            'weekendPrice' => $this->faker->randomFloat(),
            'duration' => $this->faker->randomNumber(),
            'order' => $this->faker->randomNumber(),
            'ageFrom' => $this->faker->randomNumber(),
            'ageTo' => $this->faker->randomNumber(),
            'maxChildren' => $this->faker->randomNumber(),
            'features' => $this->faker->words(),
            'badge' => $this->faker->word(),
            'color' => $this->faker->word(),
            'isActive' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
