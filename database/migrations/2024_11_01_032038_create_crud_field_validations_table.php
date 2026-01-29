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
        Schema::create('crud_field_validations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crud_id');
            $table->foreignId('crud_field_id');
            $table->foreignId('crud_input_validation_id');
            $table->string('validation_value')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crud_field_validations');
    }
};
