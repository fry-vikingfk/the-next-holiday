<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CountryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_list_of_countries()
    {
        $response = $this->get(route('countries.index'));
        
        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'List of countries',
                 ]);
    }

    public function test_store_creates_new_country()
    {
        $data = [
            'code' => 'US',
            'name' => 'United States',
        ];

        $response = $this->post('/api/countries', $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'message' => 'Country created successfully',
                 ]);

        $this->assertDatabaseHas('countries', $data);
    }

    public function test_update_country()
    {
        $country = Country::factory()->create(['code' => 'CA', 'name' => 'Canada']);

        $data = [
            'code' => 'CA',
            'name' => 'Canada Updated',
        ];

        $response = $this->patchJson(route('countries.update', $country), $data);

        $response->assertStatus(202)
                 ->assertJson([
                     'message' => 'Country updated successfully',
                 ]);

        $this->assertDatabaseHas('countries', ['id' => $country->id, ...$data]);
    }
    public function test_show_country_details()
    {
        $country = Country::factory()->create(['code' => 'GB', 'name' => 'United Kingdom']);

        $response = $this->getJson(route('countries.show', $country));

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Country details',
                     'data' => [
                         'id' => $country->id,
                         'code' => $country->code,
                         'name' => $country->name,
                     ],
                 ]);
    }
    public function test_delete_country()
    {
        $country = \App\Models\Country::factory()->create(['code' => 'FR', 'name' => 'France']);

        $response = $this->deleteJson(route('countries.destroy', $country));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('countries', ['id' => $country->id]);
    }
}
