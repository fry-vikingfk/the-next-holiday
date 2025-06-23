<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface CountryRepositoryInterface
{
    public function getCountryList(string $languageIsoCode): Collection;
}
