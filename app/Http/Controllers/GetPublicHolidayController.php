<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Resources\Holiday\HolidayResource;
use App\Http\Requests\Holiday\HolidaySearchRequest;
use App\Repositories\Contracts\HolidayRepositoryInterface;

class GetPublicHolidayController extends Controller
{
    public function __construct(
        private readonly HolidayRepositoryInterface $holidayRepository
        )
    {}

    public function __invoke(HolidaySearchRequest $request): JsonResponse
    {
        $holidays = $this->holidayRepository->getPublicHolidays($request);

        return response()->json([
            'message' => 'List of holidays',
            'data' => HolidayResource::collection(
                $holidays
            ),
        ])->setStatusCode(JsonResponse::HTTP_OK);
    }
}
