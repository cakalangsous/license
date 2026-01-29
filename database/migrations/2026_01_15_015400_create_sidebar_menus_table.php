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
        Schema::create('sidebar_menus', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('route_name');
            $table->string('icon')->nullable()->default('database');
            $table->string('section')->default('CRUD Generated');
            $table->string('permission')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('sidebar_menus')->onDelete('cascade');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sidebar_menus');
    }
};
