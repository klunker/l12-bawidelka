<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        return [
            'slug' => $this->faker->slug(),
            'title' => $this->faker->word(),
            'sub_title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'image' => $this->faker->word(),
            'template' => $this->faker->randomElement(['standard', 'special', 'urodzinki']),
            'options' => json_encode($this->faker->words()),
            'attachments' => json_encode([
                ['file' => $this->faker->word()],
                ['file' => $this->faker->word()],
            ]),
            'isActive' => $this->faker->boolean(),
            'sort_order' => $this->faker->numberBetween(0, 100),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
