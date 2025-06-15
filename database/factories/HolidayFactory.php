<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;


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
            'state_id' => State::factory(),
            'country_id' => Country::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
