<?php

namespace App\Http\Controllers;

use App\Http\Requests\Holiday\HolidaySearchRequest;
use Illuminate\Support\Collection;

class GetPublicHolidayController extends GetHolidayController
{
    protected function fetchHolidays(HolidaySearchRequest $request): Collection
    {
        return $this->holidayRepository->getPublicHolidays($request);
    }

    protected function responseMessage(): string
    {
        return 'List of public holidays';
    }
}
