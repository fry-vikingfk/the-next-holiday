<?php

namespace App\Http\Controllers;

use App\Http\Requests\Country\CountryListRequest;
use App\Http\Requests\Country\StoreCountryRequest;
use App\Http\Requests\Country\UpdateCountryRequest;
use App\Http\Resources\Country\CountryListResource;
use App\Http\Resources\Country\CountryResource;
use App\Models\Country;
use App\Repositories\Contracts\CountryRepositoryInterface;

class CountryController extends Controller
{
    public function __construct(
        private readonly CountryRepositoryInterface $countryRepository
    ) {}

    public function index(CountryListRequest $request)
    {
        $this->authorize('viewAny', Country::class);

        return response()->json([
            'message' => 'List of countries',
            'data' => CountryListResource::collection(
                $this->countryRepository->getCountryList(
                    $request->validated('languageIsoCode')
                )
            ),
        ])->setStatusCode(200);
    }

    public function store(StoreCountryRequest $request)
    {
        $this->authorize('create', Country::class);

        $country = Country::create($request->validated());

        return response()->json([
            'message' => 'Country created successfully',
            'data' => CountryResource::make($country),
        ])->setStatusCode(201);
    }

    public function show(Country $country)
    {
        $this->authorize('view', $country);

        return response()->json([
            'message' => 'Country details',
            'data' => CountryResource::make($country->load(['states.holidays'])),
        ])->setStatusCode(200);
    }

    public function update(UpdateCountryRequest $request, Country $country)
    {
        $this->authorize('update', $country);

        $country->update($request->validated());

        return response()->json([
            'message' => 'Country updated successfully',
            'data' => CountryResource::make($country),
        ])->setStatusCode(202);
    }

    public function destroy(Country $country)
    {
        $this->authorize('delete', $country);

        $country->delete();

        return response()->noContent();
    }
}
