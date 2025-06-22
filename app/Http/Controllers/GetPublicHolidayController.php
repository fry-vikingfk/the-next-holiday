<?php

namespace App\Http\Controllers;

use App\Http\Resources\Holiday\HolidayResource;
use App\Http\Requests\Holiday\HolidaySearchRequest;
use App\Repositories\Contracts\HolidayRepositoryInterface;
use App\Traits\PaginationTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class GetPublicHolidayController extends Controller
{
    use PaginationTrait;
    
    public function __construct(
        private readonly HolidayRepositoryInterface $holidayRepository
        )
    {}

    public function __invoke(HolidaySearchRequest $request): JsonResource
    {
        $paginated = $this->paginateCollection(
            $this->holidayRepository->getPublicHolidays($request),
            $request->validated('perPage'),
            $request->validated('page')
        );

        return HolidayResource::collection($paginated)
            ->additional(['message' => 'List of holidays']);
    }
}
