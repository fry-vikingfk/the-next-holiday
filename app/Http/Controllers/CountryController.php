<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Http\Resources\Country\CountryResource;
use App\Http\Requests\Country\CountryListRequest;
use App\Http\Requests\Country\StoreCountryRequest;
use App\Http\Requests\Country\UpdateCountryRequest;
use App\Http\Resources\Country\CountryListResource;
use App\Repositories\Contracts\CountryRepositoryInterface;

class CountryController extends Controller
{
    public function __construct(
        private readonly CountryRepositoryInterface $countryRepository
    )
    {}
    /**
     * Display a listing of the resource.
     */
    public function index(CountryListRequest $request)
    {
        return response()->json([
            'message' => 'List of countries',
            'data' => CountryListResource::collection(
                $this->countryRepository->getCountryList(
                    $request->validated('languageIsoCode')
                )
            ),
        ])->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCountryRequest $request)
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
    public function update(UpdateCountryRequest $request, Country $country)
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
