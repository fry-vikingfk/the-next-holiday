<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;
use App\Http\Requests\Holiday\HolidaySearchRequest;

interface HolidayRepositoryInterface
{
    public function getPublicHolidays(HolidaySearchRequest $request): Collection;
    public function getSchoolHolidays(HolidaySearchRequest $request): Collection;
}
