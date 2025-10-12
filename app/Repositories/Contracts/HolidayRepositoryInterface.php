<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\Holiday\HolidaySearchRequest;
use Illuminate\Support\Collection;

interface HolidayRepositoryInterface
{
    public function getPublicHolidays(HolidaySearchRequest $request): Collection;

    public function getSchoolHolidays(HolidaySearchRequest $request): Collection;
}
