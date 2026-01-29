<?php

return [
    /*
    |--------------------------------------------------------------------------
    | CRUD Generator Paths
    |--------------------------------------------------------------------------
    |
    | These paths define where the CRUD generator will save generated files.
    | All paths are relative to their respective base directories.
    |
    */

    'paths' => [
        // Model path (relative to app_path())
        'model' => 'Models',

        // Controller path (relative to app_path())
        'controller' => 'Http/Controllers/Admin',

        // API Controller path (relative to app_path())
        'api_controller' => 'Http/Controllers/Api',

        // Request path (relative to app_path())
        'request' => 'Http/Requests/Admin',

        // Migration path (relative to database_path())
        'migration' => 'migrations',

        // Vue pages path (relative to resource_path())
        'vue_pages' => 'js/Pages',

        // TypeScript routes path (relative to resource_path())
        'ts_routes' => 'js/routes/admin',

        // Routes file path (relative to base_path())
        'routes_file' => 'routes/crud_generated.php',

        // API Routes file path (relative to base_path())
        'api_routes_file' => 'routes/api_crud.php',

        // Stubs path (relative to resource_path())
        'stubs' => 'stubs',
    ],

    /*
    |--------------------------------------------------------------------------
    | Route Configuration
    |--------------------------------------------------------------------------
    */

    'route_prefix' => 'admin',

    'route_name_prefix' => 'admin.',

    /*
    |--------------------------------------------------------------------------
    | Sidebar Configuration
    |--------------------------------------------------------------------------
    */

    'sidebar_section' => 'CRUD Generated',

    'sidebar_icon' => 'document',
];
