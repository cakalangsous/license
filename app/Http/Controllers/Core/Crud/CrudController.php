<?php

namespace App\Http\Controllers\Core\Crud;

use App\Http\Controllers\CoreController;
use App\Http\Requests\Core\StoreCrudRequest;
use App\Services\Crud\CrudGenerator;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Inertia\Response as InertiaResponse;

class CrudController extends CoreController
{
    private $crudGenerator;

    public function __construct(CrudGenerator $crudGenerator)
    {
        $this->crudGenerator = $crudGenerator;

        $this->data['active_menu'] = 'crud';
        $this->data['title'] = 'Crud';
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): InertiaResponse
    {
        $query = DB::table('cruds');

        // Handle search
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('model_name', 'like', "%{$search}%")
                    ->orWhere('table_name', 'like', "%{$search}%");
            });
        }

        // Handle sorting
        if ($request->sort) {
            $direction = $request->direction === 'desc' ? 'desc' : 'asc';
            $query->orderBy($request->sort, $direction);
        } else {
            $query->orderByDesc('id');
        }

        $perPage = $request->per_page ?? 10;
        $paginated = $query->paginate($perPage)->withQueryString();

        // Add index_url and builder_options to each item
        $paginated->getCollection()->transform(function ($item) {
            $routeName = 'admin.'.$item->table_name.'.index';
            $hasWebRoute = Route::has($routeName);
            $item->index_url = $hasWebRoute ? route($routeName) : '#';
            // Check if this CRUD has web interface (not API-only)
            $item->has_web_route = $hasWebRoute && $item->builder_options !== 'generate_api';

            return $item;
        });

        $this->data['paginatedCruds'] = $paginated;

        return inertia('Core/Crud/Index', $this->data);
    }

    /**
     * Get columns for a specific table (AJAX endpoint).
     */
    public function getTableColumns(string $table): \Illuminate\Http\JsonResponse
    {
        try {
            $columns = DB::getSchemaBuilder()->getColumnListing($table);

            $columnOptions = array_map(function ($column) {
                return [
                    'value' => $column,
                    'label' => $column,
                ];
            }, $columns);

            return response()->json([
                'status' => 'success',
                'columns' => $columnOptions,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get table columns',
                'columns' => [],
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): InertiaResponse
    {
        $this->data['title'] = 'Create CRUD Builder';
        $this->data['input_types'] = DB::table('crud_input_types')->get();

        // Get ALL validations for the Vue component (no more AJAX fetching)
        $this->data['all_validations'] = DB::table('crud_input_validations')->get();

        // Get available tables for relation selection
        $this->data['available_tables'] = $this->getAvailableTables();

        return inertia('Core/Crud/Create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCrudRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            // Generate CRUD and get list of generated files
            $generatedFiles = $this->crudGenerator->execute($data);

            $crud['model_name'] = Str::studly($data['model_name']);
            $crud['table_name'] = $data['table_name'];
            $crud['builder_options'] = $data['builder_options'];
            $crud['soft_deletes'] = $data['soft_deletes'];
            $crud['create_page'] = $data['create_page'];
            $crud['edit_page'] = $data['edit_page'];
            $crud['show_page'] = $data['show_page'];

            $crudId = DB::table('cruds')->insertGetId($crud);

            // Save generated files to database for tracking
            $this->saveGeneratedFiles($crudId, $generatedFiles);

            $crud = $crudId;

            for ($i = 0; $i < count($data['field_name']); $i++) {
                $fields['crud_id'] = $crudId;
                $fields['field_name'] = Str::snake($data['field_name'][$i]);
                $fields['field_type'] = $data['field_type'][$i];
                $fields['default_value'] = $data['default_value'][$i] == 'none' ? ' ' : $data['default_value'][$i];
                $fields['defined_value'] = $data['defined_value'][$i];
                $fields['input_type'] = $data['input_type'][$i];
                $fields['create_page'] = (bool) $data['row_create_page'][$i];
                $fields['edit_page'] = (bool) $data['row_edit_page'][$i];
                $fields['list_page'] = (bool) $data['row_list_page'][$i];
                $fields['details_page'] = (bool) $data['row_details_page'][$i];
                $fields['searchable'] = (bool) $data['searchable'][$i];
                $fields['sortable'] = (bool) $data['sortable'][$i];
                $fields['table_ref'] = $data['table_ref'][$i] ?? null;
                $fields['value_field_ref'] = $data['value_field_ref'][$i] ?? null;
                $fields['label_field_ref'] = $data['label_field_ref'][$i] ?? null;
                $fields['where_field_ref'] = $data['where_field_ref'][$i] ?? null;

                $crud_field = DB::table('crud_fields')->insertGetId($fields);

                // Save custom options if any
                if (! empty($data['custom_options'][$i]) && is_array($data['custom_options'][$i])) {
                    foreach ($data['custom_options'][$i] as $sortOrder => $option) {
                        DB::table('crud_field_options')->insert([
                            'crud_field_id' => $crud_field,
                            'value' => $option['value'] ?? '',
                            'label' => $option['label'] ?? '',
                            'sort_order' => $sortOrder,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }

                // Insert validations for this field
                $field_validations = [];
                for ($validation = 0; $validation < count($data['validations'][$i]); $validation++) {
                    $field_validation = [
                        'crud_id' => $crudId,
                        'crud_field_id' => $crud_field,
                    ];

                    if (is_array($data['validations'][$i][$validation])) {
                        $field_validation['crud_input_validation_id'] = key($data['validations'][$i][$validation]);
                        $field_validation['validation_value'] = current($data['validations'][$i][$validation]);
                    } else {
                        $field_validation['crud_input_validation_id'] = $data['validations'][$i][$validation];
                        $field_validation['validation_value'] = null;
                    }

                    $field_validations[] = $field_validation;
                }

                if (! empty($field_validations)) {
                    DB::table('crud_field_validations')->insert($field_validations);
                }
            }

            return redirect()->route('admin.crud.index')->with('success', 'CRUD Created Successfully');

        } catch (Exception $e) {
            return back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): InertiaResponse
    {
        $crud = DB::table('cruds')->where('id', $id)->first();

        if (! $crud) {
            abort(404, 'CRUD not found');
        }

        // Get fields with their validations
        $fields = DB::table('crud_fields')
            ->where('crud_id', $id)
            ->get()
            ->map(function ($field) {
                // Get validations for this field
                $validations = DB::table('crud_field_validations')
                    ->join('crud_input_validations', 'crud_field_validations.crud_input_validation_id', '=', 'crud_input_validations.id')
                    ->where('crud_field_validations.crud_field_id', $field->id)
                    ->select(
                        'crud_input_validations.id',
                        'crud_input_validations.validation',
                        'crud_input_validations.is_input_able',
                        'crud_input_validations.input_placeholder',
                        'crud_field_validations.validation_value as value'
                    )
                    ->get();

                // Get custom options for this field
                $customOptions = DB::table('crud_field_options')
                    ->where('crud_field_id', $field->id)
                    ->orderBy('sort_order')
                    ->get()
                    ->map(fn ($opt) => [
                        'value' => $opt->value,
                        'label' => $opt->label,
                    ])
                    ->toArray();

                return [
                    'id' => $field->id,
                    'field_name' => $field->field_name,
                    'field_type' => $field->field_type,
                    'default_value' => trim($field->default_value) === '' ? 'none' : $field->default_value,
                    'defined_value' => $field->defined_value ?? '',
                    'input_type' => $field->input_type,
                    'row_create_page' => (bool) $field->create_page,
                    'row_edit_page' => (bool) $field->edit_page,
                    'row_list_page' => (bool) $field->list_page,
                    'row_details_page' => (bool) $field->details_page,
                    'searchable' => (bool) $field->searchable,
                    'sortable' => (bool) $field->sortable,
                    'table_ref' => $field->table_ref ?? '',
                    'value_field_ref' => $field->value_field_ref ?? '',
                    'label_field_ref' => $field->label_field_ref ?? '',
                    'where_field_ref' => $field->where_field_ref ?? '',
                    'custom_options' => $customOptions,
                    'validations' => $validations->map(fn ($v) => [
                        'id' => $v->id,
                        'validation' => $v->validation,
                        'is_input_able' => (bool) $v->is_input_able,
                        'placeholder' => $v->input_placeholder,
                        'value' => $v->value ?? '',
                    ])->toArray(),
                ];
            });

        $this->data['title'] = 'Edit CRUD Builder';
        $this->data['crud'] = $crud;
        $this->data['fields'] = $fields;
        $this->data['input_types'] = DB::table('crud_input_types')->get();
        $this->data['all_validations'] = DB::table('crud_input_validations')->get();
        $this->data['available_tables'] = $this->getAvailableTables();

        return inertia('Core/Crud/Edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCrudRequest $request, string $id): RedirectResponse
    {
        $data = $request->validated();

        try {
            $existingCrud = DB::table('cruds')->where('id', $id)->first();

            if (! $existingCrud) {
                return back()->withErrors(['message' => 'CRUD not found']);
            }

            // Fetch existing fields BEFORE deleting them (for update migration comparison)
            $existingFields = DB::table('crud_fields')
                ->where('crud_id', $id)
                ->get()
                ->map(fn ($field) => [
                    'field_name' => $field->field_name,
                    'field_type' => $field->field_type,
                    'default_value' => trim($field->default_value) === '' ? 'none' : $field->default_value,
                    'defined_value' => $field->defined_value,
                ])
                ->toArray();

            // Delete old generated files using database records
            $this->deleteGeneratedFilesFromDatabase($id);
            $this->removeRoutes($existingCrud->model_name, $existingCrud->table_name);

            // Regenerate CRUD files and get list of generated files (with update migration if fields changed)
            $generatedFiles = $this->crudGenerator->executeUpdate($data, $existingFields);

            // Save new generated files to database
            $this->saveGeneratedFiles($id, $generatedFiles);

            // Update CRUD record
            DB::table('cruds')->where('id', $id)->update([
                'model_name' => Str::studly($data['model_name']),
                'table_name' => $data['table_name'],
                'builder_options' => $data['builder_options'],
                'soft_deletes' => $data['soft_deletes'],
                'create_page' => $data['create_page'],
                'edit_page' => $data['edit_page'],
                'show_page' => $data['show_page'],
            ]);

            // Delete old fields and validations
            $oldFieldIds = DB::table('crud_fields')->where('crud_id', $id)->pluck('id');
            DB::table('crud_field_validations')->whereIn('crud_field_id', $oldFieldIds)->delete();
            DB::table('crud_fields')->where('crud_id', $id)->delete();

            // Insert new fields
            for ($i = 0; $i < count($data['field_name']); $i++) {
                $fields = [
                    'crud_id' => $id,
                    'field_name' => Str::snake($data['field_name'][$i]),
                    'field_type' => $data['field_type'][$i],
                    'default_value' => $data['default_value'][$i] == 'none' ? ' ' : $data['default_value'][$i],
                    'defined_value' => $data['defined_value'][$i],
                    'input_type' => $data['input_type'][$i],
                    'create_page' => (bool) $data['row_create_page'][$i],
                    'edit_page' => (bool) $data['row_edit_page'][$i],
                    'list_page' => (bool) $data['row_list_page'][$i],
                    'details_page' => (bool) $data['row_details_page'][$i],
                    'searchable' => (bool) $data['searchable'][$i],
                    'sortable' => (bool) $data['sortable'][$i],
                    'table_ref' => $data['table_ref'][$i] ?? null,
                    'value_field_ref' => $data['value_field_ref'][$i] ?? null,
                    'label_field_ref' => $data['label_field_ref'][$i] ?? null,
                    'where_field_ref' => $data['where_field_ref'][$i] ?? null,
                ];

                $crud_field = DB::table('crud_fields')->insertGetId($fields);

                // Save custom options if any
                if (! empty($data['custom_options'][$i]) && is_array($data['custom_options'][$i])) {
                    foreach ($data['custom_options'][$i] as $sortOrder => $option) {
                        DB::table('crud_field_options')->insert([
                            'crud_field_id' => $crud_field,
                            'value' => $option['value'] ?? '',
                            'label' => $option['label'] ?? '',
                            'sort_order' => $sortOrder,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }

                // Insert validations for this field
                $field_validations = [];
                for ($validation = 0; $validation < count($data['validations'][$i]); $validation++) {
                    $field_validation = [
                        'crud_id' => $id,
                        'crud_field_id' => $crud_field,
                    ];

                    if (is_array($data['validations'][$i][$validation])) {
                        $field_validation['crud_input_validation_id'] = key($data['validations'][$i][$validation]);
                        $field_validation['validation_value'] = current($data['validations'][$i][$validation]);
                    } else {
                        $field_validation['crud_input_validation_id'] = $data['validations'][$i][$validation];
                        $field_validation['validation_value'] = null;
                    }

                    $field_validations[] = $field_validation;
                }

                if (! empty($field_validations)) {
                    DB::table('crud_field_validations')->insert($field_validations);
                }
            }

            return redirect()->route('admin.crud.index')->with('success', 'CRUD Updated Successfully');

        } catch (Exception $e) {
            return back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        try {
            $crud = DB::table('cruds')->where('id', $id)->first();

            if (! $crud) {
                return back()->withErrors(['message' => 'CRUD not found']);
            }

            $modelName = $crud->model_name;
            $tableName = $crud->table_name;

            // Delete related sidebar menu
            $routeName = 'admin.'.$tableName.'.index';
            DB::table('sidebar_menus')->where('route_name', $routeName)->delete();

            // Delete related field validations
            DB::table('crud_field_validations')->where('crud_id', $id)->delete();

            // Delete related fields
            DB::table('crud_fields')->where('crud_id', $id)->delete();

            // Delete generated files using database records (includes migrations)
            $this->deleteGeneratedFilesFromDatabase($id);

            // Remove routes from crud_builder.php
            $this->removeRoutes($modelName, $tableName);

            // Delete the CRUD itself
            DB::table('cruds')->where('id', $id)->delete();

            // Regenerate Wayfinder routes
            \Illuminate\Support\Facades\Artisan::call('wayfinder:generate');

            return redirect()->route('admin.crud.index')->with('success', 'CRUD and all generated files deleted successfully');
        } catch (Exception $e) {
            return back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * Save generated files to database for tracking.
     */
    private function saveGeneratedFiles(int $crudId, array $generatedFiles): void
    {
        foreach ($generatedFiles as $file) {
            DB::table('crud_generated_files')->insert([
                'crud_id' => $crudId,
                'file_type' => $file['file_type'],
                'file_path' => $file['file_path'],
                'file_name' => $file['file_name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Delete generated files using database records.
     */
    private function deleteGeneratedFilesFromDatabase(int $crudId): void
    {
        $files = DB::table('crud_generated_files')->where('crud_id', $crudId)->get();
        $crud = DB::table('cruds')->where('id', $crudId)->first();

        // If no tracking records exist, use legacy fallback to delete files by name
        if ($files->isEmpty() && $crud) {
            $this->deleteGeneratedFiles($crud->model_name, $crud->table_name);

            return;
        }

        foreach ($files as $file) {
            $fullPath = $this->getFullPath($file->file_type, $file->file_path);

            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }

        // Delete Vue pages directory if exists
        if ($crud) {
            $vueDir = resource_path(config('crud.paths.vue_pages').'/'.Str::plural($crud->model_name));
            if (is_dir($vueDir)) {
                $this->deleteDirectory($vueDir);
            }

            // Delete TypeScript route files directory
            $routeDir = resource_path(config('crud.paths.ts_routes')."/{$crud->table_name}");
            if (is_dir($routeDir)) {
                $this->deleteDirectory($routeDir);
            }

            // Delete Actions directory
            $actionsDir = app_path('Actions/Modules/'.$crud->model_name);
            if (is_dir($actionsDir)) {
                $this->deleteDirectory($actionsDir);
            }
        }

        // Remove records from database
        DB::table('crud_generated_files')->where('crud_id', $crudId)->delete();
    }

    /**
     * Get full file path based on file type.
     */
    private function getFullPath(string $fileType, string $relativePath): string
    {
        switch ($fileType) {
            case 'model':
            case 'controller':
            case 'api_controller':
            case 'request':
            case 'action':
                return app_path($relativePath);
            case 'migration':
                return database_path($relativePath);
            case 'vue_page':
                return resource_path($relativePath);
            default:
                return base_path($relativePath);
        }
    }

    /**
     * Delete all generated files for a CRUD (legacy fallback).
     */
    private function deleteGeneratedFiles(string $modelName, string $tableName): void
    {
        // Delete Model
        $modelPath = app_path(config('crud.paths.model')."/{$modelName}.php");
        if (file_exists($modelPath)) {
            unlink($modelPath);
        }

        // Delete Controller
        $controllerPath = app_path(config('crud.paths.controller')."/{$modelName}Controller.php");
        if (file_exists($controllerPath)) {
            unlink($controllerPath);
        }

        // Delete API Controller
        $apiControllerPath = app_path(config('crud.paths.api_controller')."/{$modelName}Controller.php");
        if (file_exists($apiControllerPath)) {
            unlink($apiControllerPath);
        }

        // Delete Request
        $requestPath = app_path(config('crud.paths.request')."/Store{$modelName}Request.php");
        if (file_exists($requestPath)) {
            unlink($requestPath);
        }

        // Delete Vue pages directory
        $vueDir = resource_path(config('crud.paths.vue_pages').'/'.Str::plural($modelName));
        if (is_dir($vueDir)) {
            $this->deleteDirectory($vueDir);
        }

        // Delete TypeScript route files
        $routeDir = resource_path(config('crud.paths.ts_routes')."/{$tableName}");
        if (is_dir($routeDir)) {
            $this->deleteDirectory($routeDir);
        }
    }

    /**
     * Remove routes from crud_builder.php and api_crud.php.
     */
    private function removeRoutes(string $modelName, string $tableName): void
    {
        // Remove web routes
        $routeFile = base_path(config('crud.paths.routes_file'));

        if (file_exists($routeFile)) {
            $content = file_get_contents($routeFile);

            // Remove use statement
            $useStatement = "use App\\Http\\Controllers\\Admin\\{$modelName}Controller;\n";
            $content = str_replace($useStatement, '', $content);

            // Remove route resource line
            $routeLine = "\nRoute::resource('{$tableName}', {$modelName}Controller::class);\n";
            $content = str_replace($routeLine, '', $content);

            // Also try without leading newline
            $routeLineAlt = "Route::resource('{$tableName}', {$modelName}Controller::class);\n";
            $content = str_replace($routeLineAlt, '', $content);

            file_put_contents($routeFile, $content);
        }

        // Remove API routes
        $apiRouteFile = base_path(config('crud.paths.api_routes_file'));

        if (file_exists($apiRouteFile)) {
            $content = file_get_contents($apiRouteFile);

            // Remove use statement
            $useStatement = "use App\\Http\\Controllers\\Api\\{$modelName}Controller;\n";
            $content = str_replace($useStatement, '', $content);

            // Remove apiResource line
            $routeLine = "\nRoute::apiResource('{$tableName}', {$modelName}Controller::class);\n";
            $content = str_replace($routeLine, '', $content);

            // Also try without leading newline
            $routeLineAlt = "Route::apiResource('{$tableName}', {$modelName}Controller::class);\n";
            $content = str_replace($routeLineAlt, '', $content);

            file_put_contents($apiRouteFile, $content);
        }
    }

    /**
     * Recursively delete a directory.
     */
    private function deleteDirectory(string $dir): void
    {
        if (! is_dir($dir)) {
            return;
        }

        $files = array_diff(scandir($dir), ['.', '..']);

        foreach ($files as $file) {
            $path = $dir.DIRECTORY_SEPARATOR.$file;
            is_dir($path) ? $this->deleteDirectory($path) : unlink($path);
        }

        rmdir($dir);
    }

    /**
     * Get available tables/models for relation selection.
     */
    private function getAvailableTables(): array
    {
        // Get tables from database
        $tables = DB::select('SHOW TABLES');
        $dbName = config('database.connections.mysql.database');
        $key = "Tables_in_{$dbName}";

        // System tables to exclude
        $excludeTables = [
            'cache', 'cache_locks', 'failed_jobs', 'job_batches', 'jobs',
            'migrations', 'password_reset_tokens', 'personal_access_tokens',
            'sessions', 'crud_fields', 'crud_field_validations',
            'crud_input_types', 'crud_input_validations', 'cruds',
            'taggables', 'model_has_permissions', 'model_has_roles',
            'role_has_permissions', 'permissions', 'roles', 'crud_field_options',
            'crud_generated_files', 'settings', 'sidebar_menus', 'temporary_files',
        ];

        $availableTables = [];

        foreach ($tables as $table) {
            $tableName = $table->$key;

            if (! in_array($tableName, $excludeTables)) {
                $availableTables[] = [
                    'value' => $tableName,
                    'label' => Str::studly(Str::singular($tableName)), // Model name
                ];
            }
        }

        return $availableTables;
    }
}
