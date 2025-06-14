<?php

namespace Database\Seeders;

use App\Models\State;
use App\Models\Holiday;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = State::factory()->count(20)->create();
     
        Holiday::factory()
            ->count(50)
            ->make() // Don't persist yet
            ->each(function ($holiday) use ($states) {
                $holiday->state()->associate($states->random());
                $holiday->save();
            });
    }
}
