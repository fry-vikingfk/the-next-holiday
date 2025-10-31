<?php

namespace App\Enums;

enum CountryLocaleEnum: string
{
    case DE = 'de';
    case AT = 'at';
    case CH = 'de';
    case FR = 'fr';
    case ES = 'es';
    case IT = 'it';
    case PT = 'pt';
    case NL = 'nl';
    case BE = 'nl';
    case PL = 'pl';
    case CZ = 'cs';
    case GB = 'en';
    case IE = 'en';
    case US = 'en';
    case CA = 'en';
    case AU = 'en';
    case NZ = 'en';
    case SE = 'sv';
    case NO = 'no';
    case DK = 'da';
    case FI = 'fi';

    /**
     * Get locale from country code.
     * Returns a fallback locale if country is not found.
     */
    public static function fromCountryCode(?string $countryCode, string $fallback = 'en'): string
    {
        if ($countryCode === null) {
            return $fallback;
        }

        return self::tryFrom($countryCode)?->value ?? $fallback;
    }

    /**
     * Get all available country codes.
     */
    public static function getCountryCodes(): array
    {
        return array_map(fn ($case) => $case->name, self::cases());
    }
}
