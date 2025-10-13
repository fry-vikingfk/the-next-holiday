<?php

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

trait PaginationTrait
{
    public function paginateCollection(Collection $items, int $perPage = 15, ?int $page = null): LengthAwarePaginator
    {
        $page = $page ?: request()->get('page', 1);
        $offset = ($page - 1) * $perPage;

        return new LengthAwarePaginator(
            $items->slice($offset, $perPage)->values(),
            $items->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
}
