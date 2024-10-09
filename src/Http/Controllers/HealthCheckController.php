<?php

namespace Jmrashed\HealthCheck\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Jmrashed\HealthCheck\Services\HealthCheckService;
use Jmrashed\HealthCheck\Events\HealthCheckFailed;
use Illuminate\Support\Facades\Log;

class HealthCheckController extends Controller
{
    /**
     * The health check service instance.
     *
     * @var HealthCheckService
     */
    protected $healthCheckService;

    /**
     * Number of times a service failure must occur before notifications are triggered.
     */
    protected $failureThreshold = 3;

    /**
     * Constructor to inject the HealthCheckService.
     *
     * @param  HealthCheckService  $healthCheckService
     * @return void
     */
    public function __construct(HealthCheckService $healthCheckService)
    {
        $this->healthCheckService = $healthCheckService;
    }

    /**
     * Run the health checks and return the result.
     * Supports multiple response formats (JSON, HTML, etc.).
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $results = [
            'database' => $this->healthCheckService->checkDatabase(),
            'cache' => $this->healthCheckService->checkCache(),
        ];

        // Check external services
        foreach (config('health-check.checks.external_services') as $serviceName => $serviceUrl) {
            $results[$serviceName] = $this->healthCheckService->checkExternalService($serviceUrl);
        }

        // Determine if any services have failed
        $failures = $this->handleFailures($results);

        // Customize the response format (e.g., JSON or HTML)
        if ($request->wantsJson()) {
            return response()->json([
                'status' => $failures ? 'FAIL' : 'OK',
                'details' => $results,
            ], $failures ? 503 : 200);
        }

        return view('health-check.status', ['results' => $results]);
    }

    /**
     * Handle any service failures.
     *
     * @param  array  $results
     * @return bool   True if any failures occurred, otherwise false.
     */
 



    /**
     * Log health check results to the database.
     *
     * @param  string  $service
     * @param  string  $status
     * @param  string|null  $message
     * @param  int  $failureCount
     * @param  string  $severity
     * @param  array  $context
     * @return void
     */
    protected function logHealthCheck($service, $status, $message = null, $failureCount = 0, $severity = 'info', $context = [])
    {
        HealthCheckLog::create([
            'service_name' => $service,
            'status' => $status,
            'message' => $message,
            'failure_count' => $failureCount,
            'severity' => $severity,
            'context' => json_encode($context), // Store as JSON
        ]);
    }

    /**
     * Handle any service failures.
     *
     * @param  array  $results
     * @return bool   True if any failures occurred, otherwise false.
     */
    protected function handleFailures(array $results)
    {
        $failureDetected = false;

        foreach ($results as $service => $result) {
            if ($result['status'] === 'FAIL') {
                $failureDetected = true;

                // Log the failure
                Log::error("Health check failed for service: {$service}. Message: {$result['message']}");

                // Increment failure count in cache or session
                $failureCount = cache()->increment("health-check:failures:{$service}");

                // Log to the database
                $this->logHealthCheck($service, 'FAIL', $result['message'], $failureCount, 'critical', [
                    'url' => $result['url'] ?? null,
                ]);

                // Trigger event if failure threshold is met
                if ($failureCount >= $this->failureThreshold) {
                    event(new HealthCheckFailed(
                        $service,
                        $result['message'],
                        $failureCount,
                        'critical',
                        ['url' => $result['url'] ?? null]
                    ));

                    // Reset failure count after notification
                    cache()->forget("health-check:failures:{$service}");
                }
            } else {
                // If the service is healthy, reset the failure count
                cache()->forget("health-check:failures:{$service}");

                // Log success to the database
                $this->logHealthCheck($service, 'OK', 'Service is healthy.', 0, 'info');
            }
        }

        return $failureDetected;
    }
}
