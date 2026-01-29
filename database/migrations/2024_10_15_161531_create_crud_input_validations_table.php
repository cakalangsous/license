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
        Schema::create('crud_input_validations', function (Blueprint $table) {
            $table->id();
            $table->string('validation');
            $table->boolean('is_input_able')->default(0);
            $table->string('input_placeholder')->nullable();
            $table->string('input_validation')->nullable();
            $table->text('input_group')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crud_input_validations');
    }
};
