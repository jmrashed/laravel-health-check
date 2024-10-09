<?php

namespace Jmrashed\HealthCheck\Console;

use Illuminate\Console\Command;
use Jmrashed\HealthCheck\Services\HealthCheckService;

class HealthCheckCommand extends Command
{
    // The name and signature of the console command
    protected $signature = 'health-check:run {--detailed}';

    // The console command description
    protected $description = 'Run health checks for the system and external services.';

    protected $healthCheckService;

    public function __construct(HealthCheckService $healthCheckService)
    {
        parent::__construct();
        $this->healthCheckService = $healthCheckService;
    }

    // Execute the console command
    public function handle()
    {
        // Retrieve the results of the health checks
        $results = [
            'Database' => $this->healthCheckService->checkDatabase(),
            'Cache' => $this->healthCheckService->checkCache(),
        ];

        // External services (configured in health-check.php)
        foreach (config('health-check.checks.external_services') as $service => $url) {
            $results[ucfirst($service)] = $this->healthCheckService->checkExternalService($url);
        }

        // Display summary results in the console
        foreach ($results as $service => $result) {
            $status = $result['status'] === 'OK' ? '<info>OK</info>' : '<error>FAIL</error>';
            $this->line("{$service}: {$status}");

            // If the detailed option is passed, display the message for each check
            if ($this->option('detailed')) {
                $this->line("  - Message: {$result['message']}");
            }
        }

        // Final command output
        $this->info('Health check completed.');
    }
}
