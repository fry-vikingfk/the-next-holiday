<?php

namespace Database\Factories;

use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Holiday>
 */
class HolidayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'date' => $this->faker->date(),
            'year' => $this->faker->year(),
            'note' => $this->faker->optional()->sentence(), 
            'is_statutory' => $this->faker->boolean(50), 
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
