<?php

namespace Tests\Feature\Security;

use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_view_countries_list(): void
    {
        $response = $this->getJson('/api/countries');

        $response->assertStatus(200);
    }

    public function test_guests_can_view_single_country(): void
    {
        $country = Country::factory()->create();

        $response = $this->getJson("/api/countries/{$country->id}");

        $response->assertStatus(200);
    }

    public function test_guests_cannot_create_countries(): void
    {
        $response = $this->postJson('/api/countries', [
            'code' => 'US',
            'name' => 'United States',
        ]);

        $response->assertStatus(401);
    }

    public function test_guests_cannot_update_countries(): void
    {
        $country = Country::factory()->create();

        $response = $this->patchJson("/api/countries/{$country->id}", [
            'name' => 'Updated Name',
        ]);

        $response->assertStatus(401);
    }

    public function test_guests_cannot_delete_countries(): void
    {
        $country = Country::factory()->create();

        $response = $this->deleteJson("/api/countries/{$country->id}");

        $response->assertStatus(401);
    }

    public function test_non_admin_users_cannot_create_countries(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/countries', [
            'code' => 'US',
            'name' => 'United States',
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_users_can_create_countries(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin, 'sanctum')->postJson('/api/countries', [
            'code' => 'US',
            'name' => 'United States',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('countries', [
            'code' => 'US',
            'name' => 'United States',
        ]);
    }

    public function test_admin_users_can_update_countries(): void
    {
        $admin = User::factory()->admin()->create();
        $country = Country::factory()->create(['name' => 'Old Name']);

        $response = $this->actingAs($admin, 'sanctum')->patchJson("/api/countries/{$country->id}", [
            'code' => $country->code,
            'name' => 'New Name',
        ]);

        $response->assertStatus(202);
        $this->assertDatabaseHas('countries', [
            'id' => $country->id,
            'name' => 'New Name',
        ]);
    }

    public function test_admin_users_can_delete_countries(): void
    {
        $admin = User::factory()->admin()->create();
        $country = Country::factory()->create();

        $response = $this->actingAs($admin, 'sanctum')->deleteJson("/api/countries/{$country->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('countries', [
            'id' => $country->id,
        ]);
    }

    public function test_guests_can_view_states_list(): void
    {
        $response = $this->getJson('/api/states');

        $response->assertStatus(200);
    }

    public function test_guests_can_view_single_state(): void
    {
        $country = Country::factory()->create();
        $state = State::factory()->create(['country_id' => $country->id]);

        $response = $this->getJson("/api/states/{$state->id}");

        $response->assertStatus(200);
    }

    public function test_guests_cannot_create_states(): void
    {
        $country = Country::factory()->create();

        $response = $this->postJson('/api/states', [
            'name' => 'California',
            'code' => 'CA',
            'country_id' => $country->id,
        ]);

        $response->assertStatus(401);
    }

    public function test_guests_cannot_update_states(): void
    {
        $country = Country::factory()->create();
        $state = State::factory()->create(['country_id' => $country->id]);

        $response = $this->patchJson("/api/states/{$state->id}", [
            'name' => 'Updated State',
        ]);

        $response->assertStatus(401);
    }

    public function test_guests_cannot_delete_states(): void
    {
        $country = Country::factory()->create();
        $state = State::factory()->create(['country_id' => $country->id]);

        $response = $this->deleteJson("/api/states/{$state->id}");

        $response->assertStatus(401);
    }

    public function test_non_admin_users_cannot_create_states(): void
    {
        $user = User::factory()->create();
        $country = Country::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/states', [
            'name' => 'California',
            'code' => 'CA',
            'country_id' => $country->id,
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_users_can_create_states(): void
    {
        $admin = User::factory()->admin()->create();
        $country = Country::factory()->create();

        $response = $this->actingAs($admin, 'sanctum')->postJson('/api/states', [
            'name' => 'California',
            'code' => 'CA',
            'country_id' => $country->id,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('states', [
            'name' => 'California',
            'code' => 'CA',
        ]);
    }

    public function test_admin_users_can_update_states(): void
    {
        $admin = User::factory()->admin()->create();
        $country = Country::factory()->create();
        $state = State::factory()->create([
            'country_id' => $country->id,
            'name' => 'Old State',
        ]);

        $response = $this->actingAs($admin, 'sanctum')->patchJson("/api/states/{$state->id}", [
            'name' => 'New State',
            'code' => $state->code,
            'country_id' => $country->id,
        ]);

        $response->assertStatus(202);
        $this->assertDatabaseHas('states', [
            'id' => $state->id,
            'name' => 'New State',
        ]);
    }

    public function test_admin_users_can_delete_states(): void
    {
        $admin = User::factory()->admin()->create();
        $country = Country::factory()->create();
        $state = State::factory()->create(['country_id' => $country->id]);

        $response = $this->actingAs($admin, 'sanctum')->deleteJson("/api/states/{$state->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('states', [
            'id' => $state->id,
        ]);
    }

    public function test_policy_enforces_authentication_for_write_operations(): void
    {
        $country = Country::factory()->create();
        $state = State::factory()->create(['country_id' => $country->id]);

        // All write operations should fail without authentication
        $this->postJson('/api/countries', ['code' => 'XX', 'name' => 'Test'])
            ->assertStatus(401);

        $this->patchJson("/api/countries/{$country->id}", ['name' => 'Updated'])
            ->assertStatus(401);

        $this->deleteJson("/api/countries/{$country->id}")
            ->assertStatus(401);

        $this->postJson('/api/states', ['name' => 'Test', 'code' => 'XX', 'country_id' => $country->id])
            ->assertStatus(401);

        $this->patchJson("/api/states/{$state->id}", ['name' => 'Updated'])
            ->assertStatus(401);

        $this->deleteJson("/api/states/{$state->id}")
            ->assertStatus(401);
    }

    public function test_policy_allows_read_operations_for_everyone(): void
    {
        $country = Country::factory()->create();
        $state = State::factory()->create(['country_id' => $country->id]);

        // All read operations should succeed without authentication
        $this->getJson('/api/countries')->assertSuccessful();
        $this->getJson("/api/countries/{$country->id}")->assertSuccessful();
        $this->getJson('/api/states')->assertSuccessful();
        $this->getJson("/api/states/{$state->id}")->assertSuccessful();
    }
}
