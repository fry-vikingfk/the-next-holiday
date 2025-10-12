<?php

namespace App\Repositories\OpenHolidayApi;

use App\Repositories\Contracts\CountryRepositoryInterface;
use App\Services\OpenHolidaysApiService;
use Illuminate\Support\Collection;

class CountryRepository implements CountryRepositoryInterface
{
    public function __construct(
        private readonly OpenHolidaysApiService $service
    ) {}

    public function getCountryList(?string $languageIsoCode = ''): Collection
    {
        return $this->service->getCountries(
            languageIsoCode: $languageIsoCode
        ) ?? collect();
    }
}
