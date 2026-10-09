<?php

namespace App\Http\Resources\Concerns;

trait MapsMultilingualNames
{
    protected function mapMultilingualField(mixed $field): array
    {
        return collect($field)->map(function ($item) {
            $arr = (array) $item;

            return ['language' => $arr['language'] ?? null, 'text' => $arr['text'] ?? null];
        })->values()->all();
    }
}
