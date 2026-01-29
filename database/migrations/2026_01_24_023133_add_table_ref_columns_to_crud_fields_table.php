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
        Schema::table('crud_fields', function (Blueprint $table) {
            $table->string('table_ref')->nullable()->after('sortable');
            $table->string('value_field_ref')->nullable()->after('table_ref');
            $table->string('label_field_ref')->nullable()->after('value_field_ref');
            $table->string('where_field_ref')->nullable()->after('label_field_ref');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crud_fields', function (Blueprint $table) {
            $table->dropColumn(['table_ref', 'value_field_ref', 'label_field_ref', 'where_field_ref']);
        });
    }
};
