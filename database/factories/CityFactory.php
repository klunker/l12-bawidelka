<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    protected $model = City::class;

    public function definition(): array
    {
        return [
            'name' => fake()->city(),
            'title' => fake()->sentence(),
            'address' => fake()->streetAddress(),
            'postal_code' => fake()->postcode(),
            'phone' => fake()->phoneNumber(),
            'active' => true,
        ];
    }
}
