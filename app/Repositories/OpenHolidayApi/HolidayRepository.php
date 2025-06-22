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
    {
        
    }

 
	public function all(HolidaySearchRequest $request): array
	{
		Carbon::setLocale($request->validated('languageIsoCode', 'languageIsoCode')); // Set locale based on request

		return $this->service->getPublicHolidays(
			countryIsoCode: $request->validated('countryIsoCode', 'DE'), // Default to DE if not provided
			languageIsoCode: $request->validated('languageIsoCode', 'en'),
			subdivisionCode: $request->validated('subdivisionCode', null),
			validFrom: $request->validated('validFrom', Carbon::now()->toDateString()), // Default to start of current year
			validTo: $request->validated('validTo', Carbon::now()->endOfYear()->toDateString())  // Default to end of current year
		)->toArray();
	}

	public function find(int $id):  array
	{
		return [];
	}

	public function create(StoreHolidayRequest $request): array
	{
		return [];
	}

	public function update(UpdateHolidayRequest $request, int $id): array
	{
		return [];
	}

	public function delete($id)
	{
		// TODO: Implement delete() method.
	}
}
