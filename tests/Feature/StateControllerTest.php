<?php

use Tests\TestCase;
use App\Models\State;
use Illuminate\Support\Str;
use App\Http\Resources\StateResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StateControllerTest extends TestCase
{
       use RefreshDatabase;

    public function test_index_returns_list_of_states()
    {
        State::factory()->create(['code' => 'CA', 'name' => 'California']);
        State::factory()->create(['code' => 'NY', 'name' => 'New York']);

        $response = $this->get('/api/states');

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'List of states',
                 ])
                 ->assertJsonCount(2, 'data');

        $this->assertEquals('CA', $response->json('data.0.code'));
        $this->assertEquals('NY', $response->json('data.1.code'));
    }

    public function test_store_creates_new_state()
    {
        $data = [
            'id' => Str::uuid()->toString(),
            'code' => 'TX',
            'name' => 'Texas',
        ];
        
        $response = $this->post('/api/states', $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'message' => 'State created successfully',
                 ]);

        $this->assertDatabaseHas('states', $data);
    }

    public function test_update_state()
    {
        $state = State::factory()->create(['code' => 'FL', 'name' => 'Florida']);

        $data = [
            'code' => 'FL',
            'name' => 'Florida Updated',
        ];

        $response = $this->patchJson(route('states.update', $state), $data);

        $response->assertStatus(202)
                 ->assertJson([
                     'message' => 'State updated successfully',
                        'data' => [
                            'id' => $state->id,
                            'name' => 'Florida Updated',
                            'code' => 'FL',
                        ],
                 ]);
    }
}