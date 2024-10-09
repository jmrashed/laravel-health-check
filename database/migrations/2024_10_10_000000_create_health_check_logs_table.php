<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthCheckLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_check_logs', function (Blueprint $table) {
            $table->id();
            $table->string('service_name'); // Name of the service
            $table->string('status'); // e.g., 'OK' or 'FAIL'
            $table->text('message')->nullable(); // Optional message on failure
            $table->integer('failure_count')->default(0); // Number of consecutive failures
            $table->string('severity')->default('info'); // e.g., 'critical', 'warning'
            $table->json('context')->nullable(); // Additional context in JSON format
            $table->timestamps(); // Laravel timestamps (created_at, updated_at)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('health_check_logs');
    }
}
