<?php

use App\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
}