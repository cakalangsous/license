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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, color, image, textarea, boolean
            $table->string('group')->default('application'); // application, theme
            $table->string('label')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default application settings
        $defaults = [
            // Application Settings
            ['key' => 'app_name', 'value' => 'Laravel', 'type' => 'text', 'group' => 'application', 'label' => 'Application Name'],
            ['key' => 'meta_description', 'value' => 'A Laravel application', 'type' => 'textarea', 'group' => 'application', 'label' => 'Meta Description'],
            ['key' => 'meta_keywords', 'value' => 'laravel, web, application', 'type' => 'text', 'group' => 'application', 'label' => 'Meta Keywords'],

            // Theme Settings - Colors
            ['key' => 'primary_color', 'value' => '#6771cf', 'type' => 'color', 'group' => 'theme', 'label' => 'Primary Color'],
            ['key' => 'secondary_color', 'value' => '#6c757d', 'type' => 'color', 'group' => 'theme', 'label' => 'Secondary Color'],
            ['key' => 'success_color', 'value' => '#198754', 'type' => 'color', 'group' => 'theme', 'label' => 'Success Color'],
            ['key' => 'danger_color', 'value' => '#dc3545', 'type' => 'color', 'group' => 'theme', 'label' => 'Danger Color'],
            ['key' => 'warning_color', 'value' => '#ffc107', 'type' => 'color', 'group' => 'theme', 'label' => 'Warning Color'],
            ['key' => 'info_color', 'value' => '#0dcaf0', 'type' => 'color', 'group' => 'theme', 'label' => 'Info Color'],

            // Theme Settings - Background Colors
            ['key' => 'light_bg_color', 'value' => '#f2f7ff', 'type' => 'color', 'group' => 'theme', 'label' => 'Light Theme Background'],
            ['key' => 'dark_bg_color', 'value' => '#1a1d21', 'type' => 'color', 'group' => 'theme', 'label' => 'Dark Theme Background'],
            ['key' => 'sidebar_bg_light', 'value' => '#ffffff', 'type' => 'color', 'group' => 'theme', 'label' => 'Sidebar Background (Light)'],
            ['key' => 'sidebar_bg_dark', 'value' => '#212529', 'type' => 'color', 'group' => 'theme', 'label' => 'Sidebar Background (Dark)'],

            // Theme Settings - Images
            ['key' => 'app_logo', 'value' => null, 'type' => 'image', 'group' => 'theme', 'label' => 'Application Logo'],
            ['key' => 'app_logo_dark', 'value' => null, 'type' => 'image', 'group' => 'theme', 'label' => 'Application Logo (Dark Mode)'],
            ['key' => 'favicon', 'value' => null, 'type' => 'image', 'group' => 'theme', 'label' => 'Favicon'],
        ];

        foreach ($defaults as $default) {
            $default['created_at'] = now();
            $default['updated_at'] = now();
            \Illuminate\Support\Facades\DB::table('settings')->insert($default);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
