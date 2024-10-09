<?php

namespace Jmrashed\HealthCheck\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;

class HealthCheckService
{
    public function checkDatabase()
    {
        try {
            DB::connection()->getPdo();
            return ['status' => 'OK', 'message' => 'Database connection is healthy.'];
        } catch (\Exception $e) {
            return ['status' => 'FAIL', 'message' => $e->getMessage()];
        }
    }

    public function checkCache()
    {
        try {
            Cache::put('health_check', 'OK', 1);
            return ['status' => 'OK', 'message' => 'Cache is working.'];
        } catch (\Exception $e) {
            return ['status' => 'FAIL', 'message' => $e->getMessage()];
        }
    }

    public function checkExternalService($url)
    {
        try {
            $client = new Client();
            $response = $client->get($url);
            $responseTime = $response->getHeader('X-Response-Time');

            if ($responseTime <= config('health-check.thresholds.response_time')) {
                return ['status' => 'OK', 'message' => "$url is reachable."];
            }

            return ['status' => 'FAIL', 'message' => "$url is slow. Response time: $responseTime ms"];
        } catch (\Exception $e) {
            return ['status' => 'FAIL', 'message' => $e->getMessage()];
        }
    }
}
