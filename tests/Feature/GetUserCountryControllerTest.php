<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GetUserCountryControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    public function test_returns_default_country_for_localhost_ip(): void
    {
        $response = $this->getJson('/api/user-country', [
            'REMOTE_ADDR' => '127.0.0.1',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'countryCode' => 'IE',
                'countryName' => 'Ireland',
                'detected' => false,
                'source' => 'default',
            ]);
    }

    public function test_returns_default_country_for_private_ip(): void
    {
        $response = $this->getJson('/api/user-country', [
            'REMOTE_ADDR' => '192.168.1.100',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'countryCode' => 'IE',
                'countryName' => 'Ireland',
                'detected' => false,
                'source' => 'default',
            ]);
    }

    public function test_detects_country_from_public_ip(): void
    {
        Http::fake([
            'ip-api.com/*' => Http::response([
                'status' => 'success',
                'countryCode' => 'US',
                'country' => 'United States',
            ], 200),
        ]);

        $response = $this->getJson('/api/user-country', [
            'REMOTE_ADDR' => '8.8.8.8',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'countryCode' => 'US',
                'countryName' => 'United States',
                'detected' => true,
                'source' => 'ip-api',
            ]);
    }

    public function test_falls_back_to_default_when_api_fails(): void
    {
        Http::fake([
            'ip-api.com/*' => Http::response(null, 500),
        ]);

        $response = $this->getJson('/api/user-country', [
            'REMOTE_ADDR' => '8.8.8.8',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'countryCode' => 'IE',
                'countryName' => 'Ireland',
                'detected' => false,
                'source' => 'fallback',
            ]);
    }

    public function test_falls_back_when_api_returns_error(): void
    {
        Http::fake([
            'ip-api.com/*' => Http::response([
                'status' => 'fail',
                'message' => 'invalid query',
            ], 200),
        ]);

        $response = $this->getJson('/api/user-country', [
            'REMOTE_ADDR' => '8.8.8.8',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'countryCode' => 'IE',
                'countryName' => 'Ireland',
                'detected' => false,
                'source' => 'fallback',
            ]);
    }

    public function test_caches_result_for_24_hours(): void
    {
        Http::fake([
            'ip-api.com/*' => Http::response([
                'status' => 'success',
                'countryCode' => 'US',
                'country' => 'United States',
            ], 200),
        ]);

        $ip = '8.8.8.8';
        $cacheKey = "user_country_{$ip}";

        $this->assertFalse(Cache::has($cacheKey));

        $this->getJson('/api/user-country', [
            'REMOTE_ADDR' => $ip,
        ]);

        $this->assertTrue(Cache::has($cacheKey));

        $cached = Cache::get($cacheKey);
        $this->assertEquals('US', $cached['countryCode']);
        $this->assertEquals('United States', $cached['countryName']);
    }

    public function test_uses_cached_result_on_subsequent_requests(): void
    {
        Http::fake([
            'ip-api.com/*' => Http::response([
                'status' => 'success',
                'countryCode' => 'US',
                'country' => 'United States',
            ], 200),
        ]);

        $ip = '8.8.8.8';

        // First request - hits API
        $this->getJson('/api/user-country', [
            'REMOTE_ADDR' => $ip,
        ]);

        Http::assertSentCount(1);

        // Second request - uses cache
        $response = $this->getJson('/api/user-country', [
            'REMOTE_ADDR' => $ip,
        ]);

        // Should still be only 1 HTTP call (from first request)
        Http::assertSentCount(1);

        $response->assertStatus(200)
            ->assertJson([
                'countryCode' => 'US',
                'countryName' => 'United States',
                'detected' => true,
            ]);
    }

    public function test_handles_different_ips_separately(): void
    {
        Http::fake([
            'ip-api.com/json/8.8.8.8*' => Http::response([
                'status' => 'success',
                'countryCode' => 'US',
                'country' => 'United States',
            ], 200),
            'ip-api.com/json/1.1.1.1*' => Http::response([
                'status' => 'success',
                'countryCode' => 'AU',
                'country' => 'Australia',
            ], 200),
        ]);

        $response1 = $this->getJson('/api/user-country', [
            'REMOTE_ADDR' => '8.8.8.8',
        ]);

        $response1->assertJson([
            'countryCode' => 'US',
            'countryName' => 'United States',
        ]);

        $response2 = $this->getJson('/api/user-country', [
            'REMOTE_ADDR' => '1.1.1.1',
        ]);

        $response2->assertJson([
            'countryCode' => 'AU',
            'countryName' => 'Australia',
        ]);
    }

    public function test_response_structure_is_correct(): void
    {
        $response = $this->getJson('/api/user-country', [
            'REMOTE_ADDR' => '127.0.0.1',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'countryCode',
                'countryName',
                'detected',
                'source',
            ]);
    }

    public function test_endpoint_is_rate_limited(): void
    {
        // Make 300 requests (metadata rate limit)
        for ($i = 0; $i < 300; $i++) {
            $this->getJson('/api/user-country', [
                'REMOTE_ADDR' => '127.0.0.1',
            ]);
        }

        // 301st request should be rate limited
        $response = $this->getJson('/api/user-country', [
            'REMOTE_ADDR' => '127.0.0.1',
        ]);

        $response->assertStatus(429);
    }

    public function test_detects_various_countries(): void
    {
        Http::fake([
            'ip-api.com/json/151.80.31.103*' => Http::response([
                'status' => 'success',
                'countryCode' => 'FR',
                'country' => 'France',
            ], 200),
            'ip-api.com/json/185.2.12.56*' => Http::response([
                'status' => 'success',
                'countryCode' => 'DE',
                'country' => 'Germany',
            ], 200),
        ]);

        $response1 = $this->getJson('/api/user-country', [
            'REMOTE_ADDR' => '151.80.31.103',
        ]);

        $response1->assertJson([
            'countryCode' => 'FR',
            'countryName' => 'France',
        ]);

        $response2 = $this->getJson('/api/user-country', [
            'REMOTE_ADDR' => '185.2.12.56',
        ]);

        $response2->assertJson([
            'countryCode' => 'DE',
            'countryName' => 'Germany',
        ]);
    }

    public function test_handles_ipv6_addresses(): void
    {
        $response = $this->getJson('/api/user-country', [
            'REMOTE_ADDR' => '::1',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'countryCode' => 'IE',
                'countryName' => 'Ireland',
                'detected' => false,
                'source' => 'default',
            ]);
    }
}
