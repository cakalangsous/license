<?php

namespace App\Services\Crud;

use App\Models\SidebarMenu;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

final class CrudGenerator
{
    private $generateView;

    private $generatedFiles = [];

    public function __construct()
    {
        $this->generateView = new ViewsGenerator;
    }

    public function execute($data): array
    {
        $this->generatedFiles = [];
        $builderOption = $data['builder_options'] ?? 'generate_crud';

        $this->generateModel($data);
        $this->generateMigrations($data);
        $this->generateRequest($data);
        $this->generateUpdateRequest($data);
        $this->generateActions($data);

        if ($builderOption === 'generate_crud' || $builderOption === 'generate_crud_api') {
            $this->generateController($data);
            $this->generateRoutes($data);
            $this->generateSidebarMenu($data);
            $vueFiles = $this->generateView->execute($data);
            if (is_array($vueFiles)) {
                $this->generatedFiles = array_merge($this->generatedFiles, $vueFiles);
            }
        }

        if ($builderOption === 'generate_api' || $builderOption === 'generate_crud_api') {
            $this->generateApiController($data);
            $this->generateApiRoutes($data);
        }

        Artisan::call('migrate');
        Artisan::call('optimize:clear');
        Artisan::call('wayfinder:generate');

        return $this->generatedFiles;
    }

    public function executeUpdate($data, array $existingFields): array
    {
        $this->generatedFiles = [];
        $builderOption = $data['builder_options'] ?? 'generate_crud';

        $this->generateModel($data);
        $this->generateRequest($data);

        $this->generateUpdateMigration($data, $existingFields);

        if ($builderOption === 'generate_crud' || $builderOption === 'generate_crud_api') {
            $this->generateController($data);
            $this->generateRoutes($data);
            $this->generateSidebarMenu($data);
            $vueFiles = $this->generateView->execute($data);
            if (is_array($vueFiles)) {
                $this->generatedFiles = array_merge($this->generatedFiles, $vueFiles);
            }
        }

        if ($builderOption === 'generate_api' || $builderOption === 'generate_crud_api') {
            $this->generateApiController($data);
            $this->generateApiRoutes($data);
        }

        Artisan::call('migrate');
        Artisan::call('optimize:clear');
        Artisan::call('wayfinder:generate');

        return $this->generatedFiles;
    }

    private function trackFile(string $type, string $path, string $filename): void
    {
        $this->generatedFiles[] = [
            'file_type' => $type,
            'file_path' => $path,
            'file_name' => $filename,
        ];
    }

    private function generateModel($data)
    {
        try {
            $tableName = Str::of($data['model_name'])->snake()->plural();
            $strToReplace = ['{{ modelName }}', '{{ useSoftDeletes }}', '{{ softDeletes }}', '{{ tableName }}'];

            if ($data['soft_deletes']) {
                $replaceWith = [
                    Str::studly($data['model_name']),
                    'use Illuminate\Database\Eloquent\SoftDeletes;',
                    'use SoftDeletes;',
                    $tableName,
                ];
            } else {
                $replaceWith = [
                    Str::studly($data['model_name']),
                    '',
                    '',
                    $tableName,
                ];
            }

            $modelTemplate = str_replace(
                $strToReplace,
                $replaceWith,
                file_get_contents(resource_path(config('crud.paths.stubs').'/Model.stub'))
            );

            $filename = Str::studly($data['model_name']).'.php';
            $modelPath = app_path(config('crud.paths.model').'/'.$filename);
            file_put_contents($modelPath, $modelTemplate);

            $this->trackFile('model', config('crud.paths.model').'/'.$filename, $filename);

            return ['success' => true, 'message' => 'Model created successfully'];
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function generateMigrations($data)
    {
        try {

            $fields = [];
            for ($i = 0; $i < count($data['field_name']); $i++) {

                $fieldBuilder = Str::lower($data['field_type'][$i]).'("'.Str::lower($data['field_name'][$i]).'")';
                $field = '            $table->'.$fieldBuilder;

                switch ($data['default_value'][$i]) {
                    case 'null':
                        $field = $field.'->nullable()->default(null);';
                        break;

                    case 'as_defined':
                        $field = $field.'->default("'.$data['defined_value'][$i].'");';
                        break;
                    default:
                        $field = $field.';';
                        break;
                }

                array_push($fields, $field);
            }

            if ($data['soft_deletes']) {
                array_push($fields, '            $table->softDeletes();');
            }

            $fields = implode(PHP_EOL, $fields);

            $migrationTemplate = str_replace(
                ['{{ fields }}', '{{ table }}'],
                [$fields, Str::of($data['model_name'])->snake()->plural()],
                file_get_contents(resource_path(config('crud.paths.stubs').'/Migrations.stub'))
            );

            $migrationFilename = date('Y_m_d_His').'_create_'.Str::of($data['model_name'])->snake()->plural().'_table.php';
            $migrationPath = database_path(config('crud.paths.migration').'/'.$migrationFilename);
            file_put_contents($migrationPath, $migrationTemplate);

            $this->trackFile('migration', config('crud.paths.migration').'/'.$migrationFilename, $migrationFilename);

            return ['success' => true, 'message' => 'Migrations created successfully'];
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function generateUpdateMigration(array $data, array $existingFields): array
    {
        try {
            $tableName = Str::of($data['model_name'])->snake()->plural();

            $oldFields = [];
            foreach ($existingFields as $field) {
                $fieldName = $field['field_name'];
                $oldFields[$fieldName] = [
                    'field_type' => $field['field_type'],
                    'default_value' => $field['default_value'],
                    'defined_value' => $field['defined_value'] ?? null,
                ];
            }

            $newFields = [];
            for ($i = 0; $i < count($data['field_name']); $i++) {
                $fieldName = Str::snake($data['field_name'][$i]);
                $newFields[$fieldName] = [
                    'field_type' => $data['field_type'][$i],
                    'default_value' => $data['default_value'][$i],
                    'defined_value' => $data['defined_value'][$i] ?? null,
                ];
            }

            $addedFields = array_diff_key($newFields, $oldFields);
            $removedFields = array_diff_key($oldFields, $newFields);
            $commonFields = array_intersect_key($newFields, $oldFields);

            $modifiedFields = [];
            foreach ($commonFields as $fieldName => $newFieldData) {
                $oldFieldData = $oldFields[$fieldName];

                if ($newFieldData['field_type'] !== $oldFieldData['field_type'] ||
                    $newFieldData['default_value'] !== $oldFieldData['default_value'] ||
                    $newFieldData['defined_value'] !== $oldFieldData['defined_value']) {
                    $modifiedFields[$fieldName] = [
                        'old' => $oldFieldData,
                        'new' => $newFieldData,
                    ];
                }
            }

            if (empty($addedFields) && empty($removedFields) && empty($modifiedFields)) {
                return ['success' => true, 'message' => 'No field changes detected'];
            }

            $upChanges = [];

            foreach ($addedFields as $fieldName => $fieldData) {
                $upChanges[] = $this->buildFieldDefinition($fieldName, $fieldData);
            }

            foreach ($modifiedFields as $fieldName => $fieldData) {
                $upChanges[] = $this->buildFieldDefinition($fieldName, $fieldData['new'], true);
            }

            foreach ($removedFields as $fieldName => $fieldData) {
                $upChanges[] = "            \$table->dropColumn('{$fieldName}');";
            }

            $downChanges = [];

            foreach ($removedFields as $fieldName => $fieldData) {
                $downChanges[] = $this->buildFieldDefinition($fieldName, $fieldData);
            }

            foreach ($modifiedFields as $fieldName => $fieldData) {
                $downChanges[] = $this->buildFieldDefinition($fieldName, $fieldData['old'], true);
            }

            foreach ($addedFields as $fieldName => $fieldData) {
                $downChanges[] = "            \$table->dropColumn('{$fieldName}');";
            }

            $upChangesStr = implode(PHP_EOL, $upChanges);
            $downChangesStr = implode(PHP_EOL, $downChanges);

            $migrationTemplate = str_replace(
                ['{{ table }}', '{{ upChanges }}', '{{ downChanges }}'],
                [$tableName, $upChangesStr, $downChangesStr],
                file_get_contents(resource_path(config('crud.paths.stubs').'/UpdateMigrations.stub'))
            );

            $migrationFilename = date('Y_m_d_His').'_update_'.Str::of($data['model_name'])->snake()->plural().'_table.php';
            $migrationPath = database_path(config('crud.paths.migration').'/'.$migrationFilename);
            file_put_contents($migrationPath, $migrationTemplate);

            $this->trackFile('migration', config('crud.paths.migration').'/'.$migrationFilename, $migrationFilename);

            return ['success' => true, 'message' => 'Update migration created successfully'];
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function buildFieldDefinition(string $fieldName, array $fieldData, bool $isChange = false): string
    {
        $fieldType = Str::lower($fieldData['field_type']);
        $field = "            \$table->{$fieldType}('{$fieldName}')";

        switch ($fieldData['default_value']) {
            case 'null':
                $field .= '->nullable()->default(null)';
                break;
            case 'as_defined':
                $definedValue = $fieldData['defined_value'] ?? '';
                $field .= "->default(\"{$definedValue}\")";
                break;
        }

        if ($isChange) {
            $field .= '->change()';
        }

        $field .= ';';

        return $field;
    }

    private function generateRequest($data)
    {
        try {
            $rules = '['.PHP_EOL;

            $fileValidations = ['mimes', 'image', 'file', 'mimetypes'];

            for ($i = 0; $i < count($data['field_name']); $i++) {
                $fieldRules = [];
                $inputType = $data['input_type'][$i] ?? 'input';
                $isFileUpload = in_array($inputType, ['file', 'fileupload', 'image']);

                $data['validations'][$i] = array_reverse($data['validations'][$i]);

                for ($vals = 0; $vals < count($data['validations'][$i]); $vals++) {
                    if (is_array($data['validations'][$i][$vals])) {
                        $validation = DB::table('crud_input_validations')->where('id', key($data['validations'][$i][$vals]))->first();
                        if (! $validation) {
                            return ['success' => false, 'message' => 'Validation not found'];
                        }

                        $validationName = explode(':', $validation->validation)[0];
                        if ($isFileUpload && in_array($validationName, $fileValidations)) {
                            continue;
                        }

                        $fieldRules[] = "'".$validation->validation.':'.current($data['validations'][$i][$vals])."'";
                    } else {
                        $validation = DB::table('crud_input_validations')->where('id', $data['validations'][$i][$vals])->first();
                        if (! $validation) {
                            return ['success' => false, 'message' => 'Validation not found'];
                        }

                        if ($isFileUpload && in_array($validation->validation, $fileValidations)) {
                            continue;
                        }

                        $fieldRules[] = "'".$validation->validation."'";
                    }
                }

                if ($isFileUpload && ! in_array("'string'", $fieldRules)) {
                    $fieldRules[] = "'string'";
                }

                $rules .= '                "'.$data['field_name'][$i].'" => ['.implode(', ', $fieldRules).'],'.PHP_EOL;
            }

            $rules = $rules.'            ]';

            $modelName = Str::studly($data['model_name']);
            $modelNamePluralSnakeCase = Str::of($data['model_name'])->snake()->plural();

            $requestTemplate = str_replace(
                ['{{ modelName }}', '{{ modelNamePluralSnakeCase }}', '{{ rules }}'],
                [$modelName, $modelNamePluralSnakeCase, $rules],
                file_get_contents(resource_path(config('crud.paths.stubs').'/Request.stub'))
            );

            $requestFilename = 'Store'.$modelName.'Request.php';
            $requestPath = app_path(config('crud.paths.request').'/'.$requestFilename);
            file_put_contents($requestPath, $requestTemplate);

            $this->trackFile('request', config('crud.paths.request').'/'.$requestFilename, $requestFilename);

            return ['success' => true, 'message' => 'Requests created successfully'];
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function generateUpdateRequest($data)
    {
        try {
            $rules = '['.PHP_EOL;

            $fileValidations = ['mimes', 'image', 'file', 'mimetypes'];

            for ($i = 0; $i < count($data['field_name']); $i++) {
                $fieldRules = [];
                $inputType = $data['input_type'][$i] ?? 'input';
                $isFileUpload = in_array($inputType, ['file', 'fileupload', 'image']);

                $data['validations'][$i] = array_reverse($data['validations'][$i]);

                for ($vals = 0; $vals < count($data['validations'][$i]); $vals++) {
                    if (is_array($data['validations'][$i][$vals])) {
                        $validation = DB::table('crud_input_validations')->where('id', key($data['validations'][$i][$vals]))->first();
                        if (! $validation) {
                            return ['success' => false, 'message' => 'Validation not found'];
                        }

                        $validationName = explode(':', $validation->validation)[0];
                        if ($isFileUpload && in_array($validationName, $fileValidations)) {
                            continue;
                        }

                        $fieldRules[] = "'".$validation->validation.':'.current($data['validations'][$i][$vals])."'";
                    } else {
                        $validation = DB::table('crud_input_validations')->where('id', $data['validations'][$i][$vals])->first();
                        if (! $validation) {
                            return ['success' => false, 'message' => 'Validation not found'];
                        }

                        if ($isFileUpload && in_array($validation->validation, $fileValidations)) {
                            continue;
                        }

                        $fieldRules[] = "'".$validation->validation."'";
                    }
                }

                if ($isFileUpload && ! in_array("'string'", $fieldRules)) {
                    $fieldRules[] = "'string'";
                }

                $rules .= '                "'.$data['field_name'][$i].'" => ['.implode(', ', $fieldRules).'],'.PHP_EOL;
            }

            $rules = $rules.'            ]';

            $modelName = Str::studly($data['model_name']);
            $modelNamePluralSnakeCase = Str::of($data['model_name'])->snake()->plural();

            $requestTemplate = str_replace(
                ['{{ modelName }}', '{{ modelNamePluralSnakeCase }}', '{{ rules }}'],
                [$modelName, $modelNamePluralSnakeCase, $rules],
                file_get_contents(resource_path(config('crud.paths.stubs').'/UpdateRequest.stub'))
            );

            $requestFilename = 'Update'.$modelName.'Request.php';
            $requestPath = app_path(config('crud.paths.request').'/'.$requestFilename);
            file_put_contents($requestPath, $requestTemplate);

            $this->trackFile('request', config('crud.paths.request').'/'.$requestFilename, $requestFilename);

            return ['success' => true, 'message' => 'Update Request created successfully'];
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function generateActions($data)
    {
        try {
            $input_types = DB::table('crud_input_types')->get()->keyBy('id');

            // Common replacements
            $modelName = Str::studly($data['model_name']);
            $modelNamePluralCapital = Str::of($data['model_name'])->studly()->plural();
            $modelNameSingularLowerCase = Str::of($data['model_name'])->lower()->singular();
            $modelNameSnake = Str::of($data['model_name'])->snake()->plural();

            // Build searchable fields
            $searchableFields = '';
            for ($i = 0; $i < count($data['field_name']); $i++) {
                if (! empty($data['searchable'][$i])) {
                    $fieldName = Str::snake($data['field_name'][$i]);
                    if (empty($searchableFields)) {
                        $searchableFields .= "\$q->where('{$fieldName}', 'like', \"%{\$search}%\")";
                    } else {
                        $searchableFields .= "\n                  ->orWhere('{$fieldName}', 'like', \"%{\$search}%\")";
                    }
                }
            }
            $searchableFields = $searchableFields ? $searchableFields.';' : '// No searchable fields defined';

            // Determine file fields for file processing
            $fileFields = [];
            $fileMultipleFields = [];
            for ($i = 0; $i < count($data['field_name']); $i++) {
                $inputTypeId = $data['input_type'][$i] ?? null;
                $inputType = $inputTypeId ? ($input_types[$inputTypeId] ?? null) : null;
                $fieldName = Str::snake($data['field_name'][$i]);

                if ($inputType && $inputType->type === 'file') {
                    $fileFields[] = $fieldName;
                } elseif ($inputType && $inputType->type === 'file_multiple') {
                    $fileMultipleFields[] = $fieldName;
                }
            }

            $hasFileFields = ! empty($fileFields) || ! empty($fileMultipleFields);
            $fileImports = $hasFileFields ? "use App\\Models\\TemporaryFile;\nuse Illuminate\\Support\\Facades\\Storage;" : '';
            $filepondParam = $hasFileFields ? ', ?string $filepond = null' : '';

            // Build file processing for create
            $createFileProcessing = '';
            foreach ($fileFields as $fieldName) {
                $createFileProcessing .= "
        if (!empty(\$data['{$fieldName}'])) {
            \$temp = TemporaryFile::where('folder', \$data['{$fieldName}'])->first();
            if (\$temp) {
                \$realpath = '{$modelNameSnake}/' . uniqid() . '/' . \$temp->filename;
                Storage::disk('public')->put(\$realpath, Storage::get('temp/' . \$temp->folder . '/' . \$temp->filename));
                \$data['{$fieldName}'] = \$realpath;
                Storage::deleteDirectory('temp/' . \$temp->folder);
                \$temp->delete();
            }
        }
";
            }

            // Build file processing for update
            $updateFileProcessing = '';
            foreach ($fileFields as $fieldName) {
                $updateFileProcessing .= "
        if (!empty(\$data['{$fieldName}']) && !str_starts_with(\$data['{$fieldName}'], '{$modelNameSnake}/')) {
            \$temp = TemporaryFile::where('folder', \$data['{$fieldName}'])->first();
            if (\$temp) {
                \$realpath = '{$modelNameSnake}/' . uniqid() . '/' . \$temp->filename;
                Storage::disk('public')->put(\$realpath, Storage::get('temp/' . \$temp->folder . '/' . \$temp->filename));
                \$data['{$fieldName}'] = \$realpath;
                Storage::deleteDirectory('temp/' . \$temp->folder);
                \$temp->delete();
            }
        }
";
            }

            // Create Actions directory
            $actionsPath = app_path('Actions/Modules/'.$modelName);
            if (! is_dir($actionsPath)) {
                mkdir($actionsPath, 0755, true);
            }

            // 1. Generate GetFiltered Action
            $getFilteredTemplate = str_replace(
                ['{{ modelName }}', '{{ modelNamePluralCapital }}', '{{ searchableFields }}'],
                [$modelName, $modelNamePluralCapital, $searchableFields],
                file_get_contents(resource_path(config('crud.paths.stubs').'/GetFilteredAction.stub'))
            );
            $getFilteredFilename = 'GetFiltered'.$modelNamePluralCapital.'.php';
            file_put_contents($actionsPath.'/'.$getFilteredFilename, $getFilteredTemplate);
            $this->trackFile('action', 'Actions/Modules/'.$modelName.'/'.$getFilteredFilename, $getFilteredFilename);

            // 2. Generate Create Action
            $createTemplate = str_replace(
                ['{{ modelName }}', '{{ fileImports }}', '{{ filepondParam }}', '{{ createFileProcessing }}'],
                [$modelName, $fileImports, $filepondParam, $createFileProcessing ?: ''],
                file_get_contents(resource_path(config('crud.paths.stubs').'/CreateAction.stub'))
            );
            $createFilename = 'Create'.$modelName.'.php';
            file_put_contents($actionsPath.'/'.$createFilename, $createTemplate);
            $this->trackFile('action', 'Actions/Modules/'.$modelName.'/'.$createFilename, $createFilename);

            // 3. Generate Update Action
            $updateTemplate = str_replace(
                ['{{ modelName }}', '{{ modelNameSingularLowerCase }}', '{{ fileImports }}', '{{ filepondParam }}', '{{ updateFileProcessing }}'],
                [$modelName, $modelNameSingularLowerCase, $fileImports, $filepondParam, $updateFileProcessing ?: ''],
                file_get_contents(resource_path(config('crud.paths.stubs').'/UpdateAction.stub'))
            );
            $updateFilename = 'Update'.$modelName.'.php';
            file_put_contents($actionsPath.'/'.$updateFilename, $updateTemplate);
            $this->trackFile('action', 'Actions/Modules/'.$modelName.'/'.$updateFilename, $updateFilename);

            // 4. Generate Delete Action
            $deleteTemplate = str_replace(
                ['{{ modelName }}', '{{ modelNameSingularLowerCase }}'],
                [$modelName, $modelNameSingularLowerCase],
                file_get_contents(resource_path(config('crud.paths.stubs').'/DeleteAction.stub'))
            );
            $deleteFilename = 'Delete'.$modelName.'.php';
            file_put_contents($actionsPath.'/'.$deleteFilename, $deleteTemplate);
            $this->trackFile('action', 'Actions/Modules/'.$modelName.'/'.$deleteFilename, $deleteFilename);

            return ['success' => true, 'message' => 'Actions created successfully'];
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function generateController($data)
    {
        try {
            $input_types = DB::table('crud_input_types')->get()->keyBy('id');

            $searchableFields = '';
            for ($i = 0; $i < count($data['field_name']); $i++) {
                if (! empty($data['searchable'][$i])) {
                    $fieldName = Str::snake($data['field_name'][$i]);
                    if (empty($searchableFields)) {
                        $searchableFields .= "\$q->where('{$fieldName}', 'like', \"%{\$search}%\")";
                    } else {
                        $searchableFields .= "\n                  ->orWhere('{$fieldName}', 'like', \"%{\$search}%\")";
                    }
                }
            }

            if (empty($searchableFields)) {
                $searchableFields = '// No searchable fields defined';
            } else {
                $searchableFields .= ';';
            }

            $relationImports = [];
            $relationDataFetching = [];
            $fileFields = [];
            $fileMultipleFields = [];

            for ($i = 0; $i < count($data['field_name']); $i++) {
                $inputTypeId = $data['input_type'][$i] ?? null;
                $inputType = $inputTypeId ? ($input_types[$inputTypeId] ?? null) : null;
                $tableRef = $data['table_ref'][$i] ?? null;
                $valueFieldRef = $data['value_field_ref'][$i] ?? 'id';
                $labelFieldRef = $data['label_field_ref'][$i] ?? 'name';
                $fieldName = Str::snake($data['field_name'][$i]);

                if ($inputType && $inputType->type === 'file') {
                    $fileFields[] = $fieldName;
                } elseif ($inputType && $inputType->type === 'file_multiple') {
                    $fileMultipleFields[] = $fieldName;
                }

                if ($inputType && in_array($inputType->type, ['select', 'custom_select', 'select_multiple', 'custom_select_multiple', 'checkboxes', 'custom_checkbox', 'radio', 'custom_radio']) && ! empty($tableRef)) {

                    $modelName = Str::of($tableRef)->singular()->studly()->toString();

                    if (! in_array($modelName, array_keys($relationImports))) {
                        $relationImports[$modelName] = "use App\\Models\\{$modelName};";
                    }

                    $optionsPropName = $fieldName.'Options';
                    $relationDataFetching[] = "\$this->data['{$optionsPropName}'] = {$modelName}::select('{$valueFieldRef}', '{$labelFieldRef}')->get()->map(fn(\$item) => ['value' => \$item->{$valueFieldRef}, 'label' => \$item->{$labelFieldRef}]);";
                }
            }

            $relationImportsStr = implode("\n", array_values($relationImports));
            $relationDataFetchingStr = implode("\n        ", $relationDataFetching);

            $hasFileFields = ! empty($fileFields) || ! empty($fileMultipleFields);
            $fileImports = $hasFileFields ? "use App\\Models\\TemporaryFile;\nuse Illuminate\\Support\\Facades\\Storage;" : '';

            $storeFileProcessing = '';
            $updateFileProcessing = '';
            $modelNameSnake = Str::of($data['model_name'])->snake()->plural();

            foreach ($fileFields as $fieldName) {
                $storeFileProcessing .= "
        if (!empty(\$data['{$fieldName}'])) {
            \$temp = TemporaryFile::where('folder', \$data['{$fieldName}'])->first();
            if (\$temp) {
                \$realpath = '{$modelNameSnake}/' . uniqid() . '/' . \$temp->filename;
                Storage::disk('public')->put(\$realpath, Storage::get('temp/' . \$temp->folder . '/' . \$temp->filename));
                \$data['{$fieldName}'] = \$realpath;
                Storage::deleteDirectory('temp/' . \$temp->folder);
                \$temp->delete();
            }
        }
";
                $updateFileProcessing .= "
        if (!empty(\$data['{$fieldName}']) && !str_starts_with(\$data['{$fieldName}'], '{$modelNameSnake}/')) {
            \$temp = TemporaryFile::where('folder', \$data['{$fieldName}'])->first();
            if (\$temp) {
                \$realpath = '{$modelNameSnake}/' . uniqid() . '/' . \$temp->filename;
                Storage::disk('public')->put(\$realpath, Storage::get('temp/' . \$temp->folder . '/' . \$temp->filename));
                \$data['{$fieldName}'] = \$realpath;
                Storage::deleteDirectory('temp/' . \$temp->folder);
                \$temp->delete();
            }
        }
";
            }

            foreach ($fileMultipleFields as $fieldName) {
                $storeFileProcessing .= "
        if (!empty(\$data['{$fieldName}']) && is_array(\$data['{$fieldName}'])) {
            \$paths = [];
            foreach (\$data['{$fieldName}'] as \$folder) {
                \$temp = TemporaryFile::where('folder', \$folder)->first();
                if (\$temp) {
                    \$realpath = '{$modelNameSnake}/' . uniqid() . '/' . \$temp->filename;
                    Storage::disk('public')->put(\$realpath, Storage::get('temp/' . \$temp->folder . '/' . \$temp->filename));
                    \$paths[] = \$realpath;
                    Storage::deleteDirectory('temp/' . \$temp->folder);
                    \$temp->delete();
                }
            }
            \$data['{$fieldName}'] = json_encode(\$paths);
        }
";
                $updateFileProcessing .= "
        if (!empty(\$data['{$fieldName}']) && is_array(\$data['{$fieldName}'])) {
            \$paths = [];
            foreach (\$data['{$fieldName}'] as \$folder) {
                if (str_starts_with(\$folder, '{$modelNameSnake}/')) {
                    \$paths[] = \$folder;
                } else {
                    \$temp = TemporaryFile::where('folder', \$folder)->first();
                    if (\$temp) {
                        \$realpath = '{$modelNameSnake}/' . uniqid() . '/' . \$temp->filename;
                        Storage::disk('public')->put(\$realpath, Storage::get('temp/' . \$temp->folder . '/' . \$temp->filename));
                        \$paths[] = \$realpath;
                        Storage::deleteDirectory('temp/' . \$temp->folder);
                        \$temp->delete();
                    }
                }
            }
            \$data['{$fieldName}'] = json_encode(\$paths);
        }
";
            }

            $hasFileFields = ! empty($fileFields) || ! empty($fileMultipleFields);
            $filepondArg = $hasFileFields ? ', $request->filepond' : '';

            $controllerTemplate = str_replace(
                [
                    '{{ modelName }}',
                    '{{ modelNamePluralSnakeCase }}',
                    '{{ modelNameSingularCapital }}',
                    '{{ modelNameSingularLowerCase }}',
                    '{{ modelNamePluralLowerCase }}',
                    '{{ modelNamePluralCapital }}',
                    '{{ relationImports }}',
                    '{{ relationDataFetching }}',
                    '{{ filepondArg }}',
                ],
                [
                    Str::studly($data['model_name']),
                    Str::of($data['model_name'])->snake()->plural(),
                    Str::of($data['model_name'])->studly()->singular(),
                    Str::of($data['model_name'])->lower()->singular(),
                    Str::of($data['model_name'])->lower()->plural(),
                    Str::of($data['model_name'])->studly()->plural(),
                    $relationImportsStr,
                    $relationDataFetchingStr,
                    $filepondArg,
                ],
                file_get_contents(resource_path(config('crud.paths.stubs').'/Controller.stub'))
            );

            $controllerFilename = Str::studly($data['model_name']).'Controller.php';
            $controllerPath = app_path(config('crud.paths.controller').'/'.$controllerFilename);
            file_put_contents($controllerPath, $controllerTemplate);

            $this->trackFile('controller', config('crud.paths.controller').'/'.$controllerFilename, $controllerFilename);

            return ['success' => true, 'message' => 'Controller created successfully'];
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function generateRoutes($data)
    {
        try {
            $modelName = Str::studly($data['model_name']);
            $modelNamePluralLower = Str::of($data['model_name'])->plural()->lower();

            $route = "\nRoute::resource('{$modelNamePluralLower}', {$modelName}Controller::class);\n";

            $routeFile = base_path(config('crud.paths.routes_file'));

            if (file_exists($routeFile)) {
                $content = file_get_contents($routeFile);

                $useStatement = "use App\\Http\\Controllers\\Admin\\{$modelName}Controller;";
                if (strpos($content, $useStatement) === false) {
                    $insertPosition = strpos($content, 'use Illuminate\\Support\\Facades\\Route;');
                    if ($insertPosition !== false) {
                        $content = substr($content, 0, $insertPosition).$useStatement."\n".substr($content, $insertPosition);
                    }
                }

                $content .= $route;

                file_put_contents($routeFile, $content);
            }

        } catch (Exception $e) {
            throw $e;
        }
    }

    private function generateSidebarMenu($data)
    {
        try {
            $modelName = Str::studly($data['model_name']);
            $modelNamePluralLower = Str::of($data['model_name'])->plural()->lower();
            $modelNamePluralTitle = Str::of($data['model_name'])->plural()->title();

            $routeName = config('crud.route_name_prefix').$modelNamePluralLower.'.index';

            $permissionNames = [
                $modelNamePluralLower.'_view',
                $modelNamePluralLower.'_create',
                $modelNamePluralLower.'_update',
                $modelNamePluralLower.'_delete',
            ];

            foreach ($permissionNames as $permName) {
                DB::table('permissions')->insertOrIgnore([
                    'name' => $permName,
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $sidebarSection = 'Menu';
            $sidebarIcon = config('crud.sidebar_icon');

            $existingMenu = SidebarMenu::where('route_name', $routeName)->first();

            if (! $existingMenu) {
                $maxOrder = SidebarMenu::where('section', $sidebarSection)->max('order') ?? 0;

                SidebarMenu::create([
                    'title' => $modelNamePluralTitle,
                    'route_name' => $routeName,
                    'icon' => $sidebarIcon,
                    'section' => $sidebarSection,
                    'permission' => $modelNamePluralLower.'_view',
                    'order' => $maxOrder + 1,
                ]);

                $this->trackFile('sidebar_menu', 'database:sidebar_menus', $routeName);
            }

            return ['success' => true, 'message' => 'Sidebar menu created successfully'];
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function generateApiController($data)
    {
        try {
            $searchableFields = '';
            for ($i = 0; $i < count($data['field_name']); $i++) {
                if (! empty($data['searchable'][$i])) {
                    $fieldName = Str::snake($data['field_name'][$i]);
                    if (empty($searchableFields)) {
                        $searchableFields .= "\$q->where('{$fieldName}', 'like', \"%{\$search}%\")";
                    } else {
                        $searchableFields .= "\n                ->orWhere('{$fieldName}', 'like', \"%{\$search}%\")";
                    }
                }
            }

            if (empty($searchableFields)) {
                $searchableFields = '// No searchable fields defined';
            } else {
                $searchableFields .= ';';
            }

            $controllerTemplate = str_replace(
                [
                    '{{ modelName }}',
                    '{{ modelNameSingularCapital }}',
                    '{{ modelNameSingularLowerCase }}',
                    '{{ searchableFields }}',
                ],
                [
                    Str::studly($data['model_name']),
                    Str::of($data['model_name'])->studly()->singular(),
                    Str::of($data['model_name'])->lower()->singular(),
                    $searchableFields,
                ],
                file_get_contents(resource_path(config('crud.paths.stubs').'/ApiController.stub'))
            );

            $apiControllerDir = app_path(config('crud.paths.api_controller'));
            if (! is_dir($apiControllerDir)) {
                mkdir($apiControllerDir, 0755, true);
            }

            $apiControllerFilename = Str::studly($data['model_name']).'Controller.php';
            $controllerPath = $apiControllerDir.'/'.$apiControllerFilename;
            file_put_contents($controllerPath, $controllerTemplate);

            $this->trackFile('api_controller', config('crud.paths.api_controller').'/'.$apiControllerFilename, $apiControllerFilename);

            return ['success' => true, 'message' => 'API Controller created successfully'];
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function generateApiRoutes($data)
    {
        try {
            $modelName = Str::studly($data['model_name']);
            $modelNamePluralLower = Str::of($data['model_name'])->plural()->lower();

            $route = "\nRoute::apiResource('{$modelNamePluralLower}', {$modelName}Controller::class);\n";

            $routeFile = base_path(config('crud.paths.api_routes_file'));

            if (file_exists($routeFile)) {
                $existingContent = file_get_contents($routeFile);

                $useStatement = "use App\\Http\\Controllers\\Api\\{$modelName}Controller;\n";
                if (strpos($existingContent, $useStatement) === false) {
                    $existingContent = preg_replace(
                        '/<\?php\s*\n/',
                        "<?php\n\n{$useStatement}",
                        $existingContent,
                        1
                    );
                }

                if (strpos($existingContent, "apiResource('{$modelNamePluralLower}'") === false) {
                    $existingContent .= $route;
                }

                file_put_contents($routeFile, $existingContent);
            }

            return ['success' => true, 'message' => 'API Routes created successfully'];
        } catch (Exception $e) {
            throw $e;
        }
    }
}
