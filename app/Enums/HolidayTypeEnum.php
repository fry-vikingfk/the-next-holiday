<?php

namespace App\Enums;

enum HolidayTypeEnum: string
{
    case PUBLIC_HOLIDAY = 'public';
    case BANK_HOLIDAY = 'bank';
    case SCHOOL_HOLIDAY = 'school';
    case OBSERVED_HOLIDAY = 'observed';
    case RELIGIOUS_HOLIDAY = 'religious';

    public function label(): string
    {
        return match ($this) {
            self::PUBLIC_HOLIDAY => 'Public Holiday',
            self::BANK_HOLIDAY => 'Bank Holiday',
            self::SCHOOL_HOLIDAY => 'School Holiday',
            self::OBSERVED_HOLIDAY => 'Observed Holiday',
            self::RELIGIOUS_HOLIDAY => 'Religious Holiday',
        };
    }

    public static function values(): array
    {
        return array_map(fn ($type) => $type->value, self::cases());
    }
}
