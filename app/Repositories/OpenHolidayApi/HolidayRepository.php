<?php

namespace App\Repositories\OpenHolidayApi;

use Carbon\Carbon;
use App\Services\OpenHolidaysApiService;
use App\Http\Requests\Holiday\StoreHolidayRequest;
use App\Http\Requests\Holiday\HolidaySearchRequest;
use App\Http\Requests\Holiday\UpdateHolidayRequest;
use App\Repositories\Contracts\HolidayRepositoryInterface;

class HolidayRepository implements HolidayRepositoryInterface
{
    public function __construct(
        private readonly OpenHolidaysApiService $service
    )
    {}

	public function getPublicHolidays(HolidaySearchRequest $request): array
	{
		Carbon::setLocale($request->validated('languageIsoCode', 'languageIsoCode'));

		return $this->service->getPublicHolidays(
			countryIsoCode: $request->validated('countryIsoCode', 'DE'),
			languageIsoCode: $request->validated('languageIsoCode', 'en'),
			subdivisionCode: $request->validated('subdivisionCode', null),
			validFrom: $request->validated('validFrom', Carbon::now()->toDateString()),
			validTo: $request->validated('validTo', Carbon::now()->endOfYear()->toDateString())
		)->toArray();
	}

	public function getSchoolHolidays(HolidaySearchRequest $request): array
	{
		Carbon::setLocale($request->validated('languageIsoCode', 'languageIsoCode'));

		return $this->service->getSchoolHolidays(
			countryIsoCode: $request->validated('countryIsoCode', 'DE'),
			languageIsoCode: $request->validated('languageIsoCode', 'en'),
			subdivisionCode: $request->validated('subdivisionCode', null),
			validFrom: $request->validated('validFrom', Carbon::now()->toDateString()),
			validTo: $request->validated('validTo', Carbon::now()->endOfYear()->toDateString())
		)->toArray();
	}
}
