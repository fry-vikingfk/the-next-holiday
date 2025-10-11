<?php

namespace Tests\Feature\Security;

use App\Models\Country;
use App\Models\Holiday;
use App\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MassAssignmentProtectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_country_model_protects_against_mass_assignment(): void
    {
        // Only 'code' and 'name' should be fillable
        $fillable = (new Country)->getFillable();

        $this->assertEquals(['code', 'name'], $fillable);
    }

    public function test_state_model_protects_against_mass_assignment(): void
    {
        // Only 'name', 'code', 'country_id' should be fillable
        $fillable = (new State)->getFillable();

        $this->assertEquals(['name', 'code', 'country_id'], $fillable);
    }

    public function test_holiday_model_protects_against_mass_assignment(): void
    {
        // Expected fillable attributes
        $fillable = (new Holiday)->getFillable();

        $this->assertContains('name', $fillable);
        $this->assertContains('date', $fillable);
        $this->assertContains('state_id', $fillable);
        $this->assertContains('country_id', $fillable);
        $this->assertContains('year', $fillable);
        $this->assertContains('note', $fillable);
        $this->assertContains('is_statutory', $fillable);
    }

    public function test_country_cannot_mass_assign_id(): void
    {
        $country = Country::factory()->create();

        // Attempt to update with disallowed field
        $country->fill(['id' => 999, 'name' => 'Updated']);
        $country->save();

        // ID should not have changed
        $this->assertNotEquals(999, $country->id);
    }

    public function test_country_cannot_mass_assign_timestamps(): void
    {
        $country = Country::factory()->create();
        $originalCreatedAt = $country->created_at;

        // Attempt to update created_at (should be ignored)
        $country->fill(['created_at' => now()->subYears(10)]);
        $country->save();

        // created_at should not have changed
        $this->assertEquals($originalCreatedAt->format('Y-m-d H:i:s'), $country->fresh()->created_at->format('Y-m-d H:i:s'));
    }

    public function test_state_cannot_mass_assign_timestamps(): void
    {
        $country = Country::factory()->create();
        $state = State::factory()->create(['country_id' => $country->id]);
        $originalCreatedAt = $state->created_at;

        // Attempt to update created_at (should be ignored)
        $state->fill(['created_at' => now()->subYears(10)]);
        $state->save();

        // created_at should not have changed
        $this->assertEquals($originalCreatedAt->format('Y-m-d H:i:s'), $state->fresh()->created_at->format('Y-m-d H:i:s'));
    }

    public function test_only_fillable_attributes_can_be_mass_assigned_to_country(): void
    {
        $data = [
            'code' => 'US',
            'name' => 'United States',
            'id' => 999, // Should be ignored
            'created_at' => '2000-01-01', // Should be ignored
        ];

        $country = Country::create($data);

        $this->assertEquals('US', $country->code);
        $this->assertEquals('United States', $country->name);
        $this->assertNotEquals(999, $country->id);
        $this->assertNotEquals('2000-01-01', $country->created_at->format('Y-m-d'));
    }

    public function test_only_fillable_attributes_can_be_mass_assigned_to_state(): void
    {
        $country = Country::factory()->create();

        $data = [
            'name' => 'California',
            'code' => 'CA',
            'country_id' => $country->id,
            'id' => 999, // Should be ignored
            'updated_at' => '2000-01-01', // Should be ignored
        ];

        $state = State::create($data);

        $this->assertEquals('California', $state->name);
        $this->assertEquals('CA', $state->code);
        $this->assertEquals($country->id, $state->country_id);
        $this->assertNotEquals(999, $state->id);
        $this->assertNotEquals('2000-01-01', $state->updated_at->format('Y-m-d'));
    }
}
