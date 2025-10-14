<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GetUserCountryController extends Controller
{
    /**
     * Detect user's country based on IP address.
     */
    public function __invoke(Request $request)
    {
        // Get client IP
        $ip = $request->ip();            

        // For local development, use a default country
        if ($ip === '127.0.0.1' || $ip === '::1' || str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.')) {
            return response()->json([
                'countryCode' => 'IE', // Default to Ireland for local dev
                'countryName' => 'Ireland',
                'detected' => false,
                'source' => 'default',
            ]);
        }

        // Cache the result for this IP for 24 hours
        $cacheKey = "user_country_{$ip}";

        $countryData = Cache::remember($cacheKey, 60 * 60 * 24, function () use ($ip) {
            try {
                // Use ip-api.com (free, 45 req/min, no API key needed)
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

                // Fallback to default if API fails
                return [
                    'countryCode' => 'IE',
                    'countryName' => 'Ireland',
                    'detected' => false,
                    'source' => 'fallback',
                ];
            } catch (\Exception $e) {
                // Log error but don't expose to user
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
