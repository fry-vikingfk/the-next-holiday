<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

class GetLanguagesControllerTest extends TestCase
{
    public function test_can_get_languages()
    {
        $response = $this->getJson('/api/languages');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'isoCode',
                        'name' => [
                            '*' => [
                                'language',
                                'text',
                            ],
                        ],
                    ],
                ],
            ]);
    }

    public function test_languages_have_required_fields()
    {
        $response = $this->getJson('/api/languages');

        $response->assertStatus(200);

        $data = $response->json('data');

        $this->assertNotEmpty($data, 'Languages data should not be empty');

        foreach ($data as $language) {
            $this->assertArrayHasKey('isoCode', $language);
            $this->assertArrayHasKey('name', $language);
            $this->assertIsString($language['isoCode']);
            $this->assertIsArray($language['name']);
            $this->assertNotEmpty($language['name']);

            // Check first name entry has required structure
            $firstName = $language['name'][0];
            $this->assertArrayHasKey('language', $firstName);
            $this->assertArrayHasKey('text', $firstName);
        }
    }

    public function test_language_iso_codes_are_valid()
    {
        $response = $this->getJson('/api/languages');

        $response->assertStatus(200);

        $data = $response->json('data');

        foreach ($data as $language) {
            // ISO 639-1 language codes are 2 characters
            $this->assertEquals(2, strlen($language['isoCode']),
                "Language ISO code should be 2 characters: {$language['isoCode']}");
            $this->assertMatchesRegularExpression('/^[A-Z]{2}$/', $language['isoCode'],
                "Language ISO code should be uppercase: {$language['isoCode']}");
        }
    }
}
