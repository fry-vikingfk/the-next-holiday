<?php

namespace App\Http\Controllers;

use App\Http\Requests\Holiday\HolidaySearchRequest;
use App\Http\Resources\Holiday\HolidayResource;
use App\Repositories\Contracts\HolidayRepositoryInterface;
use App\Traits\PaginationTrait;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

abstract class GetHolidayController extends Controller
{
    use PaginationTrait;

    public function __construct(
        protected readonly HolidayRepositoryInterface $holidayRepository
    ) {}

    abstract protected function fetchHolidays(HolidaySearchRequest $request): Collection;

    abstract protected function responseMessage(): string;

    public function __invoke(HolidaySearchRequest $request): JsonResource
    {
        $paginated = $this->paginateCollection(
            $this->fetchHolidays($request),
            $request->validated('perPage'),
            $request->validated('page')
        );

        return HolidayResource::collection($paginated)
            ->additional(['message' => $this->responseMessage()]);
    }
}
