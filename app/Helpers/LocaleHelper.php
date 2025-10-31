<?php

namespace App\Helpers;

class LocaleHelper
{
    /**
     * Mapping of country codes to locales.
     * Multiple countries can map to the same locale.
     */
    private const COUNTRY_LOCALE_MAP = [
        'DE' => 'de',
        'AT' => 'de',
        'CH' => 'de',
        'FR' => 'fr',
        'ES' => 'es',
        'IT' => 'it',
        'PT' => 'pt',
        'NL' => 'nl',
        'BE' => 'nl',
        'PL' => 'pl',
        'CZ' => 'cs',
        'GB' => 'en',
        'IE' => 'en',
        'US' => 'en',
        'CA' => 'en',
        'AU' => 'en',
        'NZ' => 'en',
        'SE' => 'sv',
        'NO' => 'no',
        'DK' => 'da',
        'FI' => 'fi',
        'GR' => 'el',
        'HU' => 'hu',
        'RO' => 'ro',
        'SK' => 'sk',
        'SI' => 'sl',
        'HR' => 'hr',
        'BG' => 'bg',
        'LT' => 'lt',
        'LV' => 'lv',
        'EE' => 'et',
        'MT' => 'mt',
        'LU' => 'fr',
        'CY' => 'el',
    ];

    /**
     * Get locale from country code.
     * Returns a fallback locale if country is not found.
     */
    public static function fromCountryCode(?string $countryCode, string $fallback = 'en'): string
    {
        if ($countryCode === null) {
            return $fallback;
        }

        return self::COUNTRY_LOCALE_MAP[strtoupper($countryCode)] ?? $fallback;
    }

    /**
     * Get all available country codes.
     */
    public static function getCountryCodes(): array
    {
        return array_keys(self::COUNTRY_LOCALE_MAP);
    }

    /**
     * Get all unique locales.
     */
    public static function getAvailableLocales(): array
    {
        return array_unique(array_values(self::COUNTRY_LOCALE_MAP));
    }

    /**
     * Check if a country code is supported.
     */
    public static function hasCountryCode(string $countryCode): bool
    {
        return isset(self::COUNTRY_LOCALE_MAP[strtoupper($countryCode)]);
    }
}
