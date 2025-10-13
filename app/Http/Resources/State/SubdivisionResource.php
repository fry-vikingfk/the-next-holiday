<?php

namespace App\Http\Resources\State;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubdivisionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'isoCode' => $this->isoCode, // or $this->iso_code if that's your column
            'shortName' => $this->shortName, // or $this->short_name
            'category' => collect($this->category)->map(function ($item) {
                $item = (array) $item;

                return [
                    'language' => $item['language'] ?? null,
                    'text' => $item['text'] ?? null,
                ];
            })->values()->all(),
            'name' => collect($this->name)->map(function ($item) {
                $item = (array) $item;

                return [
                    'language' => $item['language'] ?? null,
                    'text' => $item['text'] ?? null,
                ];
            })->values()->all(),
            'officialLanguages' => $this->officialLanguages,
            'children' => isset($this->children) && $this->children
                ? SubdivisionResource::collection($this->children)
                : null,
        ];
    }
}
