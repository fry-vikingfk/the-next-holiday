<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\State\SubdivisionListRequest;
use Illuminate\Support\Collection;

interface SubdivisionRepositoryInterface
{
    public function getSubdivisionsList(SubdivisionListRequest $request): Collection;
}
