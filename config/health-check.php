<?php

return [
    'checks' => [
        'database' => true,
        'cache' => true,
        'queue' => true,
        'redis' => true,
        'external_services' => [
            'google' => 'https://www.google.com',
            'aws_s3' => 'https://s3.amazonaws.com'
        ]
    ],
    'thresholds' => [
        'response_time' => 1000, // Max acceptable response time in milliseconds
        'failure_limit' => 3     // Number of failures before notification
    ],
    'notification' => [
        'enabled' => true,
        'channels' => ['slack', 'email'],  // Integrate with Slack, email, etc.
        'email' => 'admin@yourapp.com',
        'slack_webhook_url' => env('SLACK_WEBHOOK_URL')
    ]
];
