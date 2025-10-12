<?php

namespace App\Repositories\OpenHolidayApi;

use App\Repositories\Contracts\LanguageRepositoryInterface;
use App\Services\OpenHolidaysApiService;
use Illuminate\Support\Collection;

class LanguageRepository implements LanguageRepositoryInterface
{
    public function __construct(
        private readonly OpenHolidaysApiService $service
    ) {}

    public function getLanguages(): Collection
    {
        return $this->service->getLanguages() ?? collect();
    }
}
