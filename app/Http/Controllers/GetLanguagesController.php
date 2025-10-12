<?php

namespace App\Http\Controllers;

use App\Http\Resources\Language\LanguageListResource;
use App\Repositories\Contracts\LanguageRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

class GetLanguagesController extends Controller
{
    public function __construct(
        private readonly LanguageRepositoryInterface $languageRepository
    ) {}

    public function __invoke(): JsonResource
    {
        $languages = $this->languageRepository->getLanguages();

        return LanguageListResource::collection($languages);
    }
}
