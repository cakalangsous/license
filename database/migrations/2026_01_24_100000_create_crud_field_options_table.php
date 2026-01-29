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
        Schema::create('crud_field_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crud_field_id')->constrained('crud_fields')->onDelete('cascade');
            $table->string('value');
            $table->string('label');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crud_field_options');
    }
};
