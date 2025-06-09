<?php

namespace Database\Factories;

use App\Models\State;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\State>
 */
class StateFactory extends Factory
{
    protected $model = State::class;

    public function definition(): array
    {
        
        return [
            'id' => Str::uuid(),
            'code' => fake()->lexify('??'), 
            'name' => fake()->state(), 
        ];
    }
}
