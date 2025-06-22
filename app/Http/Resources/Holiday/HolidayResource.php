<?php

namespace App\Http\Resources\Holiday;

use Illuminate\Http\Request;
use App\Http\Resources\StateResource;
use App\Http\Resources\Country\CountryResource;
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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'type' => $this->type,
            'regionalScope' => $this->regionalScope,
            'temporalScope' => $this->temporalScope,
            'nationwide' => $this->nationwide,
        ];
    }
}
