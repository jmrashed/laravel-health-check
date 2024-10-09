<?php

namespace Jmrashed\HealthCheck\Notifications;

use Illuminate\Notifications\Notification;

class HealthCheckNotification extends Notification
{
    protected $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function via($notifiable)
    {
        return ['mail', 'slack'];
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Health Check Failure')
            ->line('The following health check failed:')
            ->line($this->details);
    }

    public function toSlack($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\SlackMessage)
            ->error()
            ->content('Health Check Failure: ' . $this->details);
    }
}
