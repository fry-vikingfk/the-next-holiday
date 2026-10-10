<?php

namespace App\Http\Resources\State;

use App\Http\Resources\Concerns\MapsMultilingualNames;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubdivisionResource extends JsonResource
{
    use MapsMultilingualNames;

    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'isoCode' => $this->isoCode,
            'shortName' => $this->shortName,
            'category' => $this->mapMultilingualField($this->category),
            'name' => $this->mapMultilingualField($this->name),
            'officialLanguages' => $this->officialLanguages,
            'children' => isset($this->children) && $this->children
                ? SubdivisionResource::collection($this->children)
                : null,
        ];
    }
}
