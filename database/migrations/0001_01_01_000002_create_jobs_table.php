<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('jobs')) {
            Schema::create('jobs', function (Blueprint $table) {
                $table->id()->primary();
                $table->string('queue', 191)->index();
                $table->longText('payload', 65535);
                $table->unsignedTinyInteger('attempts');
                $table->unsignedInteger('reserved_at')->nullable();
                $table->unsignedInteger('available_at', 191);
                $table->unsignedInteger('created_at', 191);
            });
        }

        if (!Schema::hasTable('job_batches')) {

            Schema::create('job_batches', function (Blueprint $table) {
                $table->string('id', 191)->primary();
                $table->string('name', 191)->nullable();
                $table->integer('total_jobs');
                $table->integer('pending_jobs');
                $table->integer('failed_jobs');
                $table->longText('failed_job_ids')->nullable();
                $table->mediumText('options')->nullable();
                $table->integer('cancelled_at')->nullable();
                $table->integer('created_at');
                $table->integer('finished_at')->nullable();
            });
        }

        if (!Schema::hasTable('failed_jobs')) {
            Schema::create('failed_jobs', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('uuid')->unique();
                $table->text('connection', 191)->nullable();
                $table->text('queue', 191)->nullable();
                $table->longText('payload', 65535);
                $table->longText('exception', 65535);
                $table->timestamp('failed_at')->useCurrent();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
    }
};
