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
        Schema::create('crud_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crud_id');
            $table->string('field_name');
            $table->string('field_type');
            $table->string('default_value');
            $table->string('defined_value')->nullable()->default(null);
            $table->string('input_type');
            $table->boolean('create_page')->default(false);
            $table->boolean('edit_page')->default(false);
            $table->boolean('list_page')->default(false);
            $table->boolean('details_page')->default(false);
            $table->boolean('searchable')->default(false);
            $table->boolean('sortable')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crud_fields');
    }
};
