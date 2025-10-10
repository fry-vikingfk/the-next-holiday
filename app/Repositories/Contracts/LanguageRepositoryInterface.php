<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface LanguageRepositoryInterface
{
    public function getLanguages(): Collection;
}
