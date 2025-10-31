<?php

namespace App\Http\Resources\Holiday;

use App\Enums\CountryLocaleEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Resources\Json\JsonResource;

class HolidayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Get user's country from cache based on IP
        $cacheKey = "user_country_{$request->ip()}";
        $countryData = Cache::get($cacheKey);

        // Extract country code from cache and map to locale
        $countryCode = $countryData['countryCode'] ?? null;
        $locale = CountryLocaleEnum::fromCountryCode($countryCode, 'en');

        $startDate = Carbon::parse($this->startDate);
        $endDate = Carbon::parse($this->endDate);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'startDate' => $startDate->locale($locale)->translatedFormat('d. F Y.'),
            'endDate' => $endDate->locale($locale)->translatedFormat('d. F Y.'),
            'type' => $this->type,
            'regionalScope' => $this->regionalScope,
            'temporalScope' => $this->temporalScope,
            'nationwide' => $this->nationwide,
        ];
    }
}
