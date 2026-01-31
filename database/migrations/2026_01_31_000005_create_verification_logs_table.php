<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verification_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('license_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('activation_id')->nullable()->constrained()->nullOnDelete();
            $table->string('domain');
            $table->string('ip_address');
            $table->enum('request_type', ['verify', 'activate', 'deactivate', 'heartbeat']);
            $table->enum('status', ['success', 'failed', 'blocked']);
            $table->string('failure_reason')->nullable();
            $table->json('request_data')->nullable();
            $table->datetime('created_at');

            $table->index(['domain', 'created_at']);
            $table->index(['license_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verification_logs');
    }
};
