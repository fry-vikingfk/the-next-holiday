<?php

namespace App\Http\Controllers;

use App\Traits\PaginationTrait;
use App\Http\Resources\Holiday\HolidayResource;
use App\Http\Requests\Holiday\HolidaySearchRequest;
use App\Repositories\Contracts\HolidayRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

class GetSchoolHolidayController extends Controller
{
    use PaginationTrait;
    
    public function __construct(
        private readonly HolidayRepositoryInterface $holidayRepository
        )
    {}
    
    public function __invoke(HolidaySearchRequest $request): JsonResource
    {
        $paginated = $this->paginateCollection(
            $this->holidayRepository->getSchoolHolidays($request),
            $request->validated('perPage'),
            $request->validated('page')
        );

        return HolidayResource::collection($paginated)
            ->additional(['message' => 'List of school holidays']);
    }
}