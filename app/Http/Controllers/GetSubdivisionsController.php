<?php

namespace App\Http\Controllers;

use App\Http\Requests\State\SubdivisionListRequest;
use App\Http\Resources\State\SubdivisionResource;
use App\Repositories\Contracts\SubdivisionRepositoryInterface;

class GetSubdivisionsController extends Controller
{
    public function __construct(
        private readonly SubdivisionRepositoryInterface $subdivisionRepository,
    ) {}

    public function __invoke(SubdivisionListRequest $request)
    {
        return SubdivisionResource::collection(
            $this->subdivisionRepository->getSubdivisionsList($request)
        )->additional(['message' => 'List of subdivisions']);
    }
}
