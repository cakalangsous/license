<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('license_id')->constrained()->cascadeOnDelete();
            $table->string('domain');
            $table->boolean('is_local')->default(false);
            $table->string('app_version')->nullable();
            $table->string('php_version')->nullable();
            $table->string('laravel_version')->nullable();
            $table->string('server_ip')->nullable();
            $table->datetime('activated_at');
            $table->datetime('last_verified_at')->nullable();
            $table->enum('status', ['active', 'deactivated', 'blocked'])->default('active');
            $table->timestamps();

            $table->unique(['license_id', 'domain']);
            $table->index(['domain', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activations');
    }
};
