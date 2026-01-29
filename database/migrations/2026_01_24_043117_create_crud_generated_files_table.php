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
        Schema::create('crud_generated_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crud_id')->constrained('cruds')->cascadeOnDelete();
            $table->string('file_type'); // model, controller, api_controller, request, migration, vue_page, ts_route, sidebar_menu
            $table->string('file_path'); // Relative path from project root
            $table->string('file_name'); // Just the filename
            $table->timestamps();

            $table->index(['crud_id', 'file_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crud_generated_files');
    }
};
