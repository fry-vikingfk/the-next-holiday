<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\Holiday\HolidayResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StateResource extends JsonResource
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
            'code' => $this->code,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'country' => CountryResource::make($this->whenLoaded('country')),
            'holidays' => HolidayResource::collection($this->whenLoaded('holidays')),
            'links' => [
                'self' => route('states.show', $this->id),
                'update' => route('states.update', $this->id),
                'delete' => route('states.destroy', $this->id),
            ],
        ];
    }
}
