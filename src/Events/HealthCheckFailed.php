<?php

namespace Jmrashed\HealthCheck\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class HealthCheckFailed
{
    use Dispatchable, SerializesModels;

    /**
     * The name of the service that failed the health check.
     *
     * @var string
     */
    public $service;

    /**
     * Detailed message about the failure.
     *
     * @var string
     */
    public $message;

    /**
     * The number of times this service has consecutively failed.
     *
     * @var int
     */
    public $failureCount;

    /**
     * The timestamp when the failure occurred.
     *
     * @var string
     */
    public $timestamp;

    /**
     * Optional: Severity of the health check failure (e.g., critical, warning).
     *
     * @var string
     */
    public $severity;

    /**
     * Optional: Any additional context or metadata about the failure.
     *
     * @var array
     */
    public $context;

    /**
     * Create a new event instance.
     *
     * @param  string  $service
     * @param  string  $message
     * @param  int     $failureCount
     * @param  string  $severity
     * @param  array   $context
     * @return void
     */
    public function __construct(
        string $service,
        string $message,
        int $failureCount = 1,
        string $severity = 'critical',
        array $context = []
    ) {
        $this->service = $service;
        $this->message = $message;
        $this->failureCount = $failureCount;
        $this->timestamp = now()->toDateTimeString();
        $this->severity = $severity;
        $this->context = $context;
    }
}
