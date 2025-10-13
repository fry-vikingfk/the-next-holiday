<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Holiday;
use App\Models\State;
use Illuminate\Database\Seeder;

class HolidaySeeder extends Seeder
{
    public function run(): void
    {
        $countries = Country::factory()->count(5)->create();
        $states = collect();

        foreach ($countries as $country) {
            $states = $states->merge(
                State::factory()->count(4)->create([
                    'country_id' => $country->id,
                ])
            );
        }

        Holiday::factory()
            ->count(50)
            ->make() // Don't persist yet
            ->each(function ($holiday) use ($states) {
                $state = $states->random();
                $holiday->country()->associate($state->country_id); // Associate with the country of the state
                $holiday->state()->associate($state);
                $holiday->save();
            });
    }
}
