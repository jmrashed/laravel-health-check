<?php

namespace Jmrashed\HealthCheck\Middleware;

use Closure;
use Jmrashed\HealthCheck\Services\HealthCheckService;

class HealthCheckMiddleware
{
    protected $healthCheckService;

    public function __construct(HealthCheckService $service)
    {
        $this->healthCheckService = $service;
    }

    public function handle($request, Closure $next)
    {
        $status = $this->healthCheckService->checkDatabase();

        if ($status['status'] === 'FAIL') {
            return response()->json(['error' => 'Service Unavailable'], 503);
        }

        return $next($request);
    }
}
