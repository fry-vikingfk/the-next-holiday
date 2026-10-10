<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function __invoke(): View
    {
        $translations = Cache::rememberForever('translations', function (): array {
            return collect(glob(base_path('lang/*.json')))
                ->mapWithKeys(function (string $path): array {
                    $lang = strtoupper(pathinfo($path, PATHINFO_FILENAME));

                    return [$lang => json_decode(file_get_contents($path), true)];
                })
                ->toArray();
        });

        return view('landing', compact('translations'));
    }
}
