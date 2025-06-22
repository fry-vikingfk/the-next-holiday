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

    public function test_index_returns_list_of_public_holidays()
    {
        $response = $this->get('/api/holidays/public');
        $response->assertStatus(200)
        ->assertJson([
            'message' => 'List of holidays',
        ])
        ->assertJsonStructure([
            'message',
            'data' => [
                '*' => [
                    'id',
                    'name' => [
                        '*' => [
                            'language',
                            'text',
                        ],
                    ],
                    'startDate',
                    'endDate',
                    'type',
                    'regionalScope',
                    'temporalScope',
                    'nationwide',
                ],
            ],
        ]);
    }
}

