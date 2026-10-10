<?php

namespace App\Http\Resources\Country;

use App\Http\Resources\Concerns\MapsMultilingualNames;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryListResource extends JsonResource
{
    use MapsMultilingualNames;

    public function toArray(Request $request): array
    {
        return [
            'isoCode' => $this->isoCode,
            'name' => $this->mapMultilingualField($this->name),
            'officialLanguages' => $this->officialLanguages,
        ];
    }
}
