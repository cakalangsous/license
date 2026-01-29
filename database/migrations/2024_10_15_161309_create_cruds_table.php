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
        Schema::create('cruds', function (Blueprint $table) {
            $table->id();
            $table->string('model_name');
            $table->string('table_name');
            $table->string('builder_options');
            $table->boolean('soft_deletes')->dafault(false);
            $table->boolean('create_page')->dafault(false);
            $table->boolean('edit_page')->dafault(false);
            $table->boolean('show_page')->dafault(false);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cruds');
    }
};
