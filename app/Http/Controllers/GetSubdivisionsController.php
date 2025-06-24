<?php

namespace App\Http\Controllers;


use App\Http\Resources\State\SubdivisionResource;
use App\Http\Requests\State\SubdivisionListRequest;
use App\Repositories\Contracts\SubdivisionRepositoryInterface;

class GetSubdivisionsController extends Controller
{
    public function __construct(
        private readonly SubdivisionRepositoryInterface $subdivisionRepository,
    )
    {}

    public function __invoke(SubdivisionListRequest $request)
    {

        $subdivisions = $this->subdivisionRepository->getSubdivisionsList($request);

        return SubdivisionResource::collection($subdivisions)
            ->additional(['message' => 'List of subdivisions']);
    }
}
