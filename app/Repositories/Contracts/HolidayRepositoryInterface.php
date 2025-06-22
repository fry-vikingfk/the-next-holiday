<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\Holiday\StoreHolidayRequest;
use App\Http\Requests\Holiday\HolidaySearchRequest;
use App\Http\Requests\Holiday\UpdateHolidayRequest;
use App\Models\Holiday;

interface HolidayRepositoryInterface
{
    public function getPublicHolidays(HolidaySearchRequest $request): array;
    public function getSchoolHolidays(HolidaySearchRequest $request): array;
}
