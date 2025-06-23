<?php

namespace App\Repositories\OpenHolidayApi;

use Illuminate\Support\Collection;
use App\Services\OpenHolidaysApiService;
use App\Repositories\Contracts\CountryRepositoryInterface;

class CountryRepository implements CountryRepositoryInterface
{
    public function __construct(
        private readonly OpenHolidaysApiService $service
    )
    {}

    public function getCountryList(?string $languageIsoCode = ''): Collection
    {
        return $this->service->getCountries(
            languageIsoCode: $languageIsoCode
        );
    }
}
