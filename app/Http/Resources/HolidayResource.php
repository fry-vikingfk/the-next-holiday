<?php

namespace App\Http\Resources;

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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'date' => $this->date,
            'is_public' => $this->is_public,
            'year' => $this->year,
            'note' => $this->note,
            'is_statutory' => $this->is_statutory,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'state' => StateResource::make($this->whenLoaded('state')),
            'country' => CountryResource::make($this->whenLoaded('country')),
            'links' => [
                'self' => route('holidays.show', $this->id),
                'update' => route('holidays.update', $this->id),
                'delete' => route('holidays.destroy', $this->id),       
            ],
        ];
    }
}
