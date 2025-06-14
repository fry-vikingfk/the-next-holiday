<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\State;
use App\Models\Holiday;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HolidayControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_index_returns_list_of_holidays()
    {
        $holidays = Holiday::factory()->count(3)->create();

        $response = $this->get('/api/holidays');        
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'List of holidays',
            ])
             ->assertJsonStructure([
                'message',
                'data' => [
                    'current_page',
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'date',
                            'note',
                            'state_id',
                            'is_statutory',
                            'year',
                            'created_at',
                            'updated_at',
                            'state' => [
                                'id',
                                'name',
                                'created_at',
                                'updated_at',
                            ],
                        ],
                    ],
                    'first_page_url',
                    'from',
                    'last_page',
                    'last_page_url',
                    'links',
                    'next_page_url',
                    'path',
                    'per_page',
                    'prev_page_url',
                    'to',
                    'total',
                ]
            ])
            ->assertJsonCount(3, 'data.data'); // Ensure we have 3 holidays in the response
    }

    public function test_store_creates_new_holiday()
    {
        $data = [
            'id' => $this->faker->unique()->uuid(), // Unique identifier for the holiday
            'name' => $this->faker->word,
            'date' => $this->faker->date(),
            'note' => $this->faker->sentence,
            'state_id' => State::factory()->create()->id, // Create a state first
            'is_statutory' => $this->faker->boolean,
            'year' => now()->year,
        ];
        // dd($data);

        $response = $this->post('/api/holidays', $data);
        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Holiday created successfully',
            ])
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'name',
                    'date',
                    'note',
                    'state_id',
                    'is_statutory',
                    'year',
                    'created_at',
                    'updated_at',
                    'state' => [
                        'id',
                        'name',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);
    }
}

