<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Requests\CountryRequest;
use App\Http\Resources\CountryResource;
use PHPUnit\Framework\Constraint\Count;
use App\Http\Requests\CountryUpdateRequest;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'message' => 'List of countries',
            'data' => CountryResource::collection(
                Country::with(['states', 'states.holidays']
                )->paginate(10)),
        ])->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CountryRequest $request)
    {
        $country = Country::create($request->validated());

        return response()->json([
            'message' => 'Country created successfully',
            'data' => CountryResource::make($country),
        ])->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        return response()->json([
            'message' => 'Country details',
            'data' => CountryResource::make($country->load(['states', 'states.holidays'])),
        ])->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CountryUpdateRequest $request, Country $country)
    {
        $country->update($request->validated());

        return response()->json([
            'message' => 'Country updated successfully',
            'data' => CountryResource::make($country),
        ])->setStatusCode(202);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        $country->delete();

        return response()->noContent();
    }
}
