# Laravel Health Check

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jmrashed/laravel-health-check.svg?style=flat-square)](https://packagist.org/packages/jmrashed/laravel-health-check)
[![Total Downloads](https://img.shields.io/packagist/dt/jmrashed/laravel-health-check.svg?style=flat-square)](https://packagist.org/packages/jmrashed/laravel-health-check)

Advanced Laravel package for health check and performance monitoring.

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
  - [Configuration](#configuration)
  - [Running Health Checks](#running-health-checks)
- [Logging Health Checks](#logging-health-checks)
- [Notifications](#notifications)
- [Middleware](#middleware)
- [Testing](#testing)
- [Contributing](#contributing)
- [License](#license)

## Installation

You can install the package via Composer:

```bash
composer require jmrashed/laravel-health-check
```

After installing, publish the configuration file:

```bash
php artisan vendor:publish --provider="Jmrashed\HealthCheck\HealthCheckServiceProvider"
```

## Usage

### Configuration

Modify the configuration file located at `config/health-check.php` to customize your health check settings.

### Running Health Checks

You can run health checks manually using the command:

```bash
php artisan health:check
```

You can also set up a scheduled command to automate this.

## Logging Health Checks

Health check results are logged in the database. You can view logs by visiting:

```
/health-check/logs
```

This will display all the health check logs for monitoring and debugging.

## Notifications

Set up notifications to get alerted when a health check fails. Notifications can be configured in the `HealthCheckNotification` class.

## Middleware

You can apply the health check middleware to your routes to ensure they are always monitored:

```php
Route::middleware('health.check')->group(function () {
    // Your routes
});
```

## Testing

Run the tests using PHPUnit:

```bash
vendor/bin/phpunit
```

Make sure to set up your testing environment according to Laravel’s testing guidelines.

## Contributing

Contributions are welcome! Please open an issue or submit a pull request on GitHub.

## License

This package is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

