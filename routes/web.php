<?php

use Illuminate\Support\Facades\Route;
use Jmrashed\HealthCheck\Http\Controllers\HealthCheckController;
use Jmrashed\HealthCheck\Http\Controllers\HealthCheckLogController;

Route::get('health-check', [HealthCheckController::class, 'index']);
Route::get('health-check/logs', [HealthCheckLogController::class, 'index'])->name('health-check.logs.index');
