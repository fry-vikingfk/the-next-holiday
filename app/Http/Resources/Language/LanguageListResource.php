<?php

namespace App\Http\Resources\Language;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LanguageListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'isoCode' => $this->isoCode,
            'name' => collect($this->name)->map(function ($name) {
                return [
                    'language' => is_array($name) ? $name['language'] : $name->language,
                    'text' => is_array($name) ? $name['text'] : $name->text,
                ];
            })->values(),
        ];
    }
}
