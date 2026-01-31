<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('marketplace_id')->constrained()->cascadeOnDelete();
            $table->string('purchase_code')->unique();
            $table->string('buyer_email');
            $table->string('buyer_name')->nullable();
            $table->string('buyer_username')->nullable();
            $table->enum('license_type', ['regular', 'extended'])->default('regular');
            $table->datetime('purchased_at');
            $table->datetime('supported_until')->nullable();
            $table->enum('status', ['active', 'suspended', 'revoked', 'expired'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['product_id', 'status']);
            $table->index('buyer_email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
