<?php

namespace Jmrashed\HealthCheck;

use Illuminate\Support\ServiceProvider;
use Jmrashed\HealthCheck\Console\HealthCheckCommand;

class HealthCheckServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Merge the package's configuration file with the application's configuration
        $this->mergeConfigFrom(
            __DIR__ . '/../config/health-check.php', // Path to the package's config file
            'health-check' // The key under which the config will be merged
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish the configuration file to the application's config directory
        $this->publishes([
            __DIR__ . '/../config/health-check.php' => config_path('health-check.php'),
        ], 'config');

        // Register the console commands if the application is running in the console
        if ($this->app->runningInConsole()) {
            $this->commands([
                HealthCheckCommand::class, // Registering the health check console command
            ]);
        }

        // Load views from the package into the application's view namespace
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'health-check');

        // Load the package's routes file
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }
}
