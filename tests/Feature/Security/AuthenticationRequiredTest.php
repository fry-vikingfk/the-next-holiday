<?php

namespace Tests\Feature\Security;

use Tests\TestCase;

class AuthenticationRequiredTest extends TestCase
{
    public function test_unauthenticated_users_cannot_create_states(): void
    {
        $response = $this->postJson('/api/states', [
            'name' => 'Test State',
            'code' => 'TS',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    public function test_unauthenticated_users_cannot_update_states(): void
    {
        $response = $this->patchJson('/api/states/1', [
            'name' => 'Updated State',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    public function test_unauthenticated_users_cannot_delete_states(): void
    {
        $response = $this->deleteJson('/api/states/1');

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    public function test_unauthenticated_users_cannot_create_countries(): void
    {
        $response = $this->postJson('/api/countries', [
            'name' => 'Test Country',
            'code' => 'TC',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    public function test_unauthenticated_users_cannot_update_countries(): void
    {
        $response = $this->patchJson('/api/countries/1', [
            'name' => 'Updated Country',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    public function test_unauthenticated_users_cannot_delete_countries(): void
    {
        $response = $this->deleteJson('/api/countries/1');

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    public function test_read_operations_do_not_require_authentication(): void
    {
        // GET operations should work without authentication
        $response = $this->getJson('/api/holidays/public');
        $this->assertNotEquals(401, $response->status());

        $response = $this->getJson('/api/languages');
        $this->assertNotEquals(401, $response->status());

        $response = $this->getJson('/api/subdivisions?countryIsoCode=IE');
        $this->assertNotEquals(401, $response->status());
    }
}
