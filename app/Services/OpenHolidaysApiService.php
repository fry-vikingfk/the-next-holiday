<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class OpenHolidaysApiService
{
    public const BASE_URL = 'https://openholidaysapi.org/';

    private const TTL_HOLIDAYS = 15 * 60;   // 15 minutes

    private const TTL_METADATA = 60 * 60;   // 60 minutes

    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => self::BASE_URL,
            'timeout' => 10.0,
        ]);
    }

    public function getPublicHolidays(
        string $countryIsoCode,
        string $languageIsoCode,
        ?string $subdivisionCode,
        string $validFrom,
        string $validTo
    ): ?Collection {
        $sub = $subdivisionCode ?? 'none';
        $key = "holidays.public.{$countryIsoCode}.{$languageIsoCode}.{$sub}.{$validFrom}.{$validTo}";

        return Cache::remember($key, self::TTL_HOLIDAYS,
            fn () => $this->fetchHolidaysFromApi('PublicHolidays', $countryIsoCode, $languageIsoCode, $subdivisionCode, $validFrom, $validTo)
        );
    }

    public function getSchoolHolidays(
        string $countryIsoCode,
        string $languageIsoCode,
        ?string $subdivisionCode,
        string $validFrom,
        string $validTo
    ): ?Collection {
        $sub = $subdivisionCode ?? 'none';
        $key = "holidays.school.{$countryIsoCode}.{$languageIsoCode}.{$sub}.{$validFrom}.{$validTo}";

        return Cache::remember($key, self::TTL_HOLIDAYS,
            fn () => $this->fetchHolidaysFromApi('SchoolHolidays', $countryIsoCode, $languageIsoCode, $subdivisionCode, $validFrom, $validTo)
        );
    }

    private function fetchHolidaysFromApi(
        string $endpoint,
        string $countryIsoCode,
        string $languageIsoCode,
        ?string $subdivisionCode,
        string $validFrom,
        string $validTo
    ): ?Collection {
        try {
            $response = $this->client->get($endpoint, [
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
            Log::error("Error fetching {$endpoint}: ".$e->getMessage());

            return null;
        }
    }

    public function getCountries(?string $languageIsoCode = ''): ?Collection
    {
        $key = "countries.{$languageIsoCode}";

        return Cache::remember($key, self::TTL_METADATA, function () use ($languageIsoCode) {
            try {
                $query = $languageIsoCode ? ['languageIsoCode' => $languageIsoCode] : [];
                $response = $this->client->get('Countries', ['query' => $query]);

                return collect(json_decode($response->getBody()->getContents()));

            } catch (GuzzleException $e) {
                Log::error('Failed to fetch countries: '.$e->getMessage());

                return null;
            }
        });
    }

    public function getSubdivisions(
        string $countryIsoCode,
        ?string $languageIsoCode = null
    ): ?Collection {
        $key = "subdivisions.{$countryIsoCode}.{$languageIsoCode}";

        return Cache::remember($key, self::TTL_METADATA, function () use ($countryIsoCode, $languageIsoCode) {
            try {
                $response = $this->client->get('Subdivisions', [
                    'query' => [
                        'countryIsoCode' => $countryIsoCode,
                        'languageIsoCode' => $languageIsoCode,
                    ],
                ]);

                return collect(json_decode($response->getBody()->getContents()));

            } catch (GuzzleException $e) {
                Log::error("Failed to fetch subdivisions for {$countryIsoCode}: ".$e->getMessage());

                return null;
            }
        });
    }

    public function getLanguages(): ?Collection
    {
        return Cache::remember('languages', self::TTL_METADATA, function () {
            try {
                $response = $this->client->get('Languages');

                return collect(json_decode($response->getBody()->getContents()));

            } catch (GuzzleException $e) {
                Log::error('Failed to fetch languages: '.$e->getMessage());

                return null;
            }
        });
    }
}
