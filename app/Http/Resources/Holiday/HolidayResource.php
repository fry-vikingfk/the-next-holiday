<?php

namespace App\Http\Resources\Holiday;

use Illuminate\Http\Request;
use Carbon\Carbon;
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
            'startDate' => Carbon::parse($this->startDate)->format('d.m.Y'),
            'endDate' => Carbon::parse($this->endDate)->format('d.m.Y'),
            'type' => $this->type,
            'regionalScope' => $this->regionalScope,
            'temporalScope' => $this->temporalScope,
            'nationwide' => $this->nationwide,
        ];
    }
}
