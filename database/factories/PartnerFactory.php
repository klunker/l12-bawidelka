<?php

namespace Database\Factories;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

class PartnerFactory extends Factory
{
    protected $model = Partner::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'logo' => 'partners/'.$this->faker->uuid().'.png',
            'photo' => 'partners/'.$this->faker->uuid().'.jpg',
            'url' => $this->faker->url(),
            'isActive' => $this->faker->boolean(80), // 80% chance of being active
            'order' => $this->faker->numberBetween(1, 100),
        ];
    }
}
