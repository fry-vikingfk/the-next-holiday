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

		$subdivision = trim((string) ($request->validated('subdivisionCode') ?? '')) ?: null;

		$items = $this->service->getSchoolHolidays(
			countryIsoCode:  $request->validated('countryIsoCode'),
			languageIsoCode: $request->validated('languageIsoCode'),
			subdivisionCode: $subdivision,
			validFrom:       $request->validated('validFrom'),
			validTo:         $request->validated('validTo'),
		) ?? collect();

		// If no subdivision was requested, many countries return 1 entry per region.
		// Deduplicate by (localized name + startDate + endDate).
		if ($subdivision === null) {
			$lang = $request->validated('languageIsoCode');
			$items = $items
				->unique(function ($h) use ($lang) {
					// pick localized name if present, else first name entry
					$names = collect($h->name ?? []);
					$localized = $names->firstWhere('language', $lang);
					$text = $localized->text ?? ($names[0]->text ?? '');
					return ($text ?: '') . '|' . ($h->startDate ?? '') . '|' . ($h->endDate ?? '');
				})
				->values();
		}

		return $items;
	}
}
