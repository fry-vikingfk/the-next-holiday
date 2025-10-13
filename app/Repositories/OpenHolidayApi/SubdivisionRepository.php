<?php

namespace App\Repositories\OpenHolidayApi;

use App\Repositories\Contracts\SubdivisionRepositoryInterface;
use App\Services\OpenHolidaysApiService;
use Illuminate\Support\Collection;

class SubdivisionRepository implements SubdivisionRepositoryInterface
{
    public function __construct(
        private readonly OpenHolidaysApiService $service
    ) {}

    public function getSubdivisionsList($request): Collection
    {
        return $this->service->getSubdivisions(
            languageIsoCode: $request->validated('languageIsoCode'),
            countryIsoCode: $request->validated('countryIsoCode')
        ) ?? collect();
    }
}
