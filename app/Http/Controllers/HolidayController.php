<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;
use App\Http\Resources\HolidayResource;
use App\Http\Requests\StoreHolidayRequest;
use App\Http\Requests\UpdateHolidayRequest;
use App\Http\Resources\HolidayStoreResource;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'message' => 'List of holidays',
            'data' => Holiday::with('state')->paginate(10),
        ])->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHolidayRequest $request)
    {
        return response()->json([
            'message' => 'Holiday created successfully',
            'data' => HolidayStoreResource::make(
                Holiday::create($request->validated())
            ),
        ])->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'message' => 'Holiday details',
            'data' => HolidayResource::make(
                Holiday::with('state')->findOrFail($id)
            ),
        ])->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHolidayRequest $request, string $id)
    {
        $holiday = Holiday::findOrFail($id);
        $holiday->update($request->validated());

        return response()->json([
            'message' => 'Holiday updated successfully',
            'data' => HolidayResource::make($holiday),
        ])->setStatusCode(202);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $holiday = Holiday::findOrFail($id);
        $holiday->delete();

        return response()->noContent();
    }
}
