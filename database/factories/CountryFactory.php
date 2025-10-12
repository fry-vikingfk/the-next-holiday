<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->countryCode(), // ISO 3166-1 alpha-2
            'name' => $this->faker->country(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
