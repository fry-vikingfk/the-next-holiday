<?php

namespace App\Http\Controllers;

use App\Http\Requests\Holiday\HolidaySearchRequest;
use Illuminate\Support\Collection;

class GetSchoolHolidayController extends GetHolidayController
{
    protected function fetchHolidays(HolidaySearchRequest $request): Collection
    {
        return $this->holidayRepository->getSchoolHolidays($request);
    }

    protected function responseMessage(): string
    {
        return 'List of school holidays';
    }
}
