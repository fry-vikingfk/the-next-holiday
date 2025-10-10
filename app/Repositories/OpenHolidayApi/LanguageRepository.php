<?php

namespace App\Repositories\OpenHolidayApi;

use Illuminate\Support\Collection;
use App\Services\OpenHolidaysApiService;
use App\Repositories\Contracts\LanguageRepositoryInterface;

class LanguageRepository implements LanguageRepositoryInterface
{
    public function __construct(
        private readonly OpenHolidaysApiService $service
    )
    {}

    public function getLanguages(): Collection
    {
        return $this->service->getLanguages();
    }
}
