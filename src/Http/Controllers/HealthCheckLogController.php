<?php

namespace Jmrashed\HealthCheck\Http\Controllers;

use Jmrashed\HealthCheck\Models\HealthCheckLog;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HealthCheckLogController extends Controller
{
    /**
     * Display a listing of the health check logs.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Retrieve logs with pagination
        $logs = HealthCheckLog::orderBy('created_at', 'desc')->paginate(10);

        return view('health-check.logs.index', compact('logs'));
    }
}
