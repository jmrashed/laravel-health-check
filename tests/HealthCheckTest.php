<?php

namespace Jmrashed\HealthCheck\Tests;

use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\Route;

class HealthCheckTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return ['Jmrashed\\HealthCheck\\HealthCheckServiceProvider'];
    }

    public function test_database_check()
    {
        $response = $this->get('/health-check');
        $response->assertStatus(200)
            ->assertJsonStructure(['database', 'cache', 'google']);
    }
}
