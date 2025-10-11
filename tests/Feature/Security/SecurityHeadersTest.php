<?php

namespace Tests\Feature\Security;

use Tests\TestCase;

class SecurityHeadersTest extends TestCase
{
    public function test_response_has_x_frame_options_header(): void
    {
        $response = $this->get('/api/holidays/public');

        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
    }

    public function test_response_has_x_content_type_options_header(): void
    {
        $response = $this->get('/api/holidays/public');

        $response->assertHeader('X-Content-Type-Options', 'nosniff');
    }

    public function test_response_has_x_xss_protection_header(): void
    {
        $response = $this->get('/api/holidays/public');

        $response->assertHeader('X-XSS-Protection', '1; mode=block');
    }

    public function test_response_has_content_security_policy_header(): void
    {
        $response = $this->get('/api/holidays/public');

        $this->assertTrue($response->headers->has('Content-Security-Policy'));
        $csp = $response->headers->get('Content-Security-Policy');
        $this->assertStringContainsString("default-src 'self'", $csp);
    }

    public function test_response_has_referrer_policy_header(): void
    {
        $response = $this->get('/api/holidays/public');

        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }

    public function test_response_has_permissions_policy_header(): void
    {
        $response = $this->get('/api/holidays/public');

        $this->assertTrue($response->headers->has('Permissions-Policy'));
    }

    public function test_strict_transport_security_not_set_in_non_production(): void
    {
        // HSTS should only be set in production
        config(['app.env' => 'local']);

        $response = $this->get('/api/holidays/public');

        $this->assertFalse($response->headers->has('Strict-Transport-Security'));
    }

    public function test_all_security_headers_present_on_api_endpoints(): void
    {
        $response = $this->get('/api/languages');

        $response->assertHeader('X-Frame-Options');
        $response->assertHeader('X-Content-Type-Options');
        $response->assertHeader('X-XSS-Protection');
        $response->assertHeader('Content-Security-Policy');
        $response->assertHeader('Referrer-Policy');
        $response->assertHeader('Permissions-Policy');
    }

    public function test_security_headers_present_on_web_routes(): void
    {
        $response = $this->get('/');

        $response->assertHeader('X-Frame-Options');
        $response->assertHeader('X-Content-Type-Options');
    }
}
