<?php

namespace Jmrashed\HealthCheck\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthCheckLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_name',
        'status',
        'message',
        'failure_count',
        'severity',
        'context',
    ];

    /**
     * The casts for the attributes.
     *
     * @var array
     */
    protected $casts = [
        'context' => 'json',
        'failure_count' => 'integer',
    ];
}
