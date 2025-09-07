<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Requests\Country\CountryListRequest;
use App\Http\Resources\Country\CountryListResource;
use App\Repositories\Contracts\CountryRepositoryInterface;

class GetCountryListController extends Controller
{
    public function __construct(
        private readonly CountryRepositoryInterface $countryRepository
    )
    {}

    public function __invoke(CountryListRequest $request): JsonResource
    {
        $countries = $this->countryRepository->getCountryList(
            $request->validated('languageIsoCode')
        );

        return CountryListResource::collection($countries);
    }
}
