<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\GuzzleException;

class OpenHolidaysApiService
{
    public const BASE_URL = 'https://openholidaysapi.org/';

    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => self::BASE_URL, // Base API URL
            'timeout'  => 10.0, // Timeout in seconds
        ]);
    }

    public function getPublicHolidays(
        string $countryIsoCode, 
        string $languageIsoCode = '',
        ?string $subdivisionCode = null,
        string $validFrom, 
        string $validTo
    ): ?Collection
    {
        try {
            $response = $this->client->get('PublicHolidays', [
                'query' => [
                    'countryIsoCode' => $countryIsoCode,
                    'languageIsoCode' => $languageIsoCode,
                    'subdivisionCode' => $subdivisionCode,
                    'validFrom' => $validFrom,
                    'validTo' => $validTo,
                ],
            ]);

            return collect(json_decode($response->getBody()->getContents()));

        } catch (GuzzleException $e) {
            Log::error('Error fetching public holidays: ' . $e->getMessage());

            return null;
        }
    }

    public function getSchoolHolidays(
        string $countryIsoCode, 
        string $languageIsoCode = '', 
        ?string $subdivisionCode = null,
        string $validFrom, 
        string $validTo
    ): ?Collection
    {
        try {
            $response = $this->client->get('SchoolHolidays', [
                'query' => [
                    'countryIsoCode' => $countryIsoCode,
                    'languageIsoCode' => $languageIsoCode,
                    'subdivisionCode' => $subdivisionCode,
                    'validFrom' => $validFrom,
                    'validTo' => $validTo,
                ],
            ]);

            return collect(json_decode($response->getBody()->getContents()));

        } catch (GuzzleException $e) {
            Log::error('Error fetching school holidays: ' . $e->getMessage());

            return null;
        }
    }

    public function getCountries(?string $languageIsoCode = ''): ?Collection 
    {
        try {
            $query = $languageIsoCode ? ['languageIsoCode' => $languageIsoCode] : [];
            $response = $this->client->get('Countries', [
                'query' => $query,
            ]);

            return collect(json_decode($response->getBody()->getContents()));
            
        } catch (GuzzleException $e) {
            Log::error("Failed to fetch countries: " . $e->getMessage());

            return null;
        }
    }

    public function getSubdivisions(
        string $countryIsoCode,
        ?string $languageIsoCode = null
    ): ?Collection
    {
        try {
            $response = $this->client->get("Subdivisions", [
                'query' => [
                    'countryIsoCode' => $countryIsoCode,
                    'languageIsoCode' => $languageIsoCode,
                ],
            ]);

            return collect(json_decode($response->getBody()->getContents()));

        } catch (GuzzleException $e) {
            Log::error("Failed to fetch subdivisions for {$countryIsoCode}: " . $e->getMessage());

            return null;
        }
    }

    public function getLanguages(): ?Collection
    {
        try {
            $response = $this->client->get('Languages');

            return collect(json_decode($response->getBody()->getContents()));

        } catch (GuzzleException $e) {
            Log::error("Failed to fetch languages: " . $e->getMessage());

            return null;
        }
    }
}