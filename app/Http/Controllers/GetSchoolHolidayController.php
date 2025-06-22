<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\Holiday\HolidaySearchRequest;
use App\Http\Resources\Holiday\HolidayResource;
use App\Repositories\Contracts\HolidayRepositoryInterface;

class GetSchoolHolidayController extends Controller
{
    public function __construct(
        private readonly HolidayRepositoryInterface $holidayRepository
        )
    {}
    
    public function __invoke(HolidaySearchRequest $request): JsonResponse
    {
        $holidays = $this->holidayRepository->getSchoolHolidays($request);

        return response()->json([
            'message' => 'List of school holidays',
            'data' => HolidayResource::collection(
                $holidays
            ),
        ])->setStatusCode(JsonResponse::HTTP_OK);
    }
}
