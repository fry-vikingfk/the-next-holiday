<?php

namespace App\Http\Resources\Language;

use App\Http\Resources\Concerns\MapsMultilingualNames;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LanguageListResource extends JsonResource
{
    use MapsMultilingualNames;

    public function toArray(Request $request): array
    {
        return [
            'isoCode' => $this->isoCode,
            'name' => $this->mapMultilingualField($this->name),
        ];
    }
}
