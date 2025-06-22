<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetSchoolHolidayControllerTest extends TestCase
{
    public function test_index_returns_list_of_school_holidays()
    {
        $response = $this->get('/api/holidays/school');
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'List of school holidays',
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
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next',
                ],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'path',
                    'per_page',
                    'to',
                    'total',
                ],
            ]);
    }

    public function test_index_fails_validation_if_invalid_country_code()
    {
        $response = $this->getJson(
            '/api/holidays/school?countryIsoCode=INVALID&validFrom=2025-01-01&validTo=2025-12-31&languageIsoCode=DE'
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['countryIsoCode']);
    }

    public function test_index_fails_validation_if_invalid_language_code()
    {
        $response = $this->getJson(
            '/api/holidays/school?countryIsoCode=DE&validFrom=2025-01-01&validTo=2025-12-31&languageIsoCode=INVALID'
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['languageIsoCode']);
    }

    public function test_index_fails_validation_if_invalid_date_format()
    {
        $response = $this->getJson(
            '/api/holidays/school?countryIsoCode=DE&validFrom=invalid-date&validTo=2025-12-31&languageIsoCode=DE'
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['validFrom']);
    }

    public function test_index_fails_validation_if_invalid_to_date()
    {
        $response = $this->getJson(
            '/api/holidays/school?countryIsoCode=DE&validFrom=2025-01-01&validTo=invalid-date&languageIsoCode=DE'
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['validTo']);
    }

    public function test_index_fails_validation_if_invalid_subdivision_code()
    {
        $response = $this->getJson(
            '/api/holidays/school?countryIsoCode=DE&subdivisionCode=INVALID&validFrom=2025-01-01&validTo=2025-12-31&languageIsoCode=DE'
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['subdivisionCode']);
    }

    public function test_index_returns_empty_data_when_no_holidays_found()
    {
        $response = $this->getJson(
            '/api/holidays/school?countryIsoCode=DE&validFrom=2025-01-01&validTo=2025-12-31&languageIsoCode=DE'
        );

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'List of school holidays',
                'data' => [],
            ]);
    }
}
