<?php

namespace App\Http\Resources\Holiday;

use Carbon\Carbon;
use Illuminate\Http\Request;
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
        // Get locale from request's languageIsoCode parameter (selected in frontend dropdown)
        $locale = strtolower($request->input('languageIsoCode', 'en'));

        $startDate = Carbon::parse($this->startDate);
        $endDate = Carbon::parse($this->endDate);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'startDate' => $startDate->locale($locale)->translatedFormat('l, d. F Y.'),
            'endDate' => $endDate->locale($locale)->translatedFormat('l, d. F Y.'),
            'type' => $this->type,
            'regionalScope' => $this->regionalScope,
            'temporalScope' => $this->temporalScope,
            'nationwide' => $this->nationwide,
        ];
    }
}
