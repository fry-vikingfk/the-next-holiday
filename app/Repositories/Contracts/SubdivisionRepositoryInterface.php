<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;
use App\Http\Requests\State\SubdivisionListRequest;

interface SubdivisionRepositoryInterface
{
    public function getSubdivisionsList(SubdivisionListRequest $request): Collection;
}
