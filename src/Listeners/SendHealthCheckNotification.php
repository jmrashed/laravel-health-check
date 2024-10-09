<?php

namespace Jmrashed\HealthCheck\Listeners;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Jmrashed\HealthCheck\Notifications\HealthCheckNotification;
use Jmrashed\HealthCheck\Events\HealthCheckFailed;

class SendHealthCheckNotification
{
    public function handle(HealthCheckFailed $event)
    {
        Log::error("Health check failed for {$event->service}: {$event->message}", $event->context);

        // Send email
        Mail::to(config('health-check.notification.email'))
            ->send(new HealthCheckNotification($event->details));

        // Send Slack notification
        if (in_array('slack', config('health-check.notification.channels'))) {
            Notification::route('slack', config('health-check.notification.slack_webhook_url'))
                ->notify(new HealthCheckNotification($event->details));
        }
    }
}
