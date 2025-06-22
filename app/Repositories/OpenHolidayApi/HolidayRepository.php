<?php

namespace App\Repositories\OpenHolidayApi;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Services\OpenHolidaysApiService;
use App\Http\Requests\Holiday\HolidaySearchRequest;
use App\Repositories\Contracts\HolidayRepositoryInterface;

class HolidayRepository implements HolidayRepositoryInterface
{
    public function __construct(
        private readonly OpenHolidaysApiService $service
    )
    {}

	public function getPublicHolidays(HolidaySearchRequest $request): Collection
	{
		Carbon::setLocale($request->validated('languageIsoCode', 'languageIsoCode'));
		
		return $this->service->getPublicHolidays(
			countryIsoCode: $request->validated('countryIsoCode'),
			languageIsoCode: $request->validated('languageIsoCode'),
			subdivisionCode: $request->validated('subdivisionCode'),
			validFrom: $request->validated('validFrom'),
			validTo: $request->validated('validTo')
		);
	}

	public function getSchoolHolidays(HolidaySearchRequest $request): Collection
	{
		Carbon::setLocale($request->validated('languageIsoCode', 'languageIsoCode'));

		return $this->service->getSchoolHolidays(
			countryIsoCode: $request->validated('countryIsoCode'),
			languageIsoCode: $request->validated('languageIsoCode'),
			subdivisionCode: $request->validated('subdivisionCode'),
			validFrom: $request->validated('validFrom'),
			validTo: $request->validated('validTo')
		);
	}
}
