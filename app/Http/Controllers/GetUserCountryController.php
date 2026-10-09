<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GetUserCountryController extends Controller
{
    public function __invoke(Request $request)
    {
        $ip = $request->ip();

        if ($ip === '127.0.0.1' || $ip === '::1' || str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.')) {
            return response()->json([
                'countryCode' => 'IE',
                'countryName' => 'Ireland',
                'detected' => false,
                'source' => 'default',
            ]);
        }

        $countryData = Cache::remember("user_country_{$ip}", 60 * 60 * 24, function () use ($ip) {
            try {
                $response = Http::timeout(5)->get("http://ip-api.com/json/{$ip}", [
                    'fields' => 'status,message,countryCode,country',
                ]);

                if ($response->successful() && $response->json('status') === 'success') {
                    return [
                        'countryCode' => $response->json('countryCode'),
                        'countryName' => $response->json('country'),
                        'detected' => true,
                        'source' => 'ip-api',
                    ];
                }

                return [
                    'countryCode' => 'IE',
                    'countryName' => 'Ireland',
                    'detected' => false,
                    'source' => 'fallback',
                ];
            } catch (\Exception $e) {
                logger()->warning('IP geolocation failed', [
                    'ip' => $ip,
                    'error' => $e->getMessage(),
                ]);

                return [
                    'countryCode' => 'IE',
                    'countryName' => 'Ireland',
                    'detected' => false,
                    'source' => 'error',
                ];
            }
        });

        return response()->json($countryData);
    }
}
