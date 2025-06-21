<?php

namespace App\Repositories\OpenHolidayApi;

use App\Http\Requests\Holiday\StoreHolidayRequest;
use App\Http\Requests\Holiday\UpdateHolidayRequest;
use App\Repositories\Contracts\HolidayRepositoryInterface;
use App\Services\OpenHolidaysApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rules\In;

class HolidayRepository implements HolidayRepositoryInterface
{
    public function __construct(
        private readonly OpenHolidaysApiService $service
        )
    {
        
    }

	public function all(): array
	{
		return $this->service->getPublicHolidays(
			countryIsoCode: 'DE', // Default to Germany
			languageIsoCode: 'en', // Default language
			validFrom: '2023-01-01', // Default start date
			validTo: '2023-12-31'  // Default end date
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
