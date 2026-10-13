<?php

namespace Tests\Feature;

use Tests\TestCase;

class HealthTest extends TestCase
{
    public function test_health_returns_ok(): void
    {
        $response = $this->getJson('/api/health');

        $response->assertOk()
            ->assertExactJson([
                'status' => 'ok',
            ]);
    }

    public function test_health_allows_the_local_frontend_origin(): void
    {
        $response = $this->withHeader('Origin', 'http://localhost:5173')
            ->getJson('/api/health');

        $response->assertOk()
            ->assertHeader('Access-Control-Allow-Origin', 'http://localhost:5173');
    }
}
