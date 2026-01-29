<?php

namespace App\Services\Crud;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

final class ViewsGenerator
{
    private $generatedFiles = [];

    public function execute($data): array
    {
        $this->generatedFiles = [];

        $this->generateIndexPage($data);

        if ($data['create_page']) {
            $this->generateCreatePage($data);
        }

        if ($data['edit_page']) {
            $this->generateEditPage($data);
        }

        if ($data['show_page']) {
            $this->generateShowPage($data);
        }

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

    private function generateIndexPage($data)
    {
        try {
            $input_types = DB::table('crud_input_types')->get()->keyBy('id');

            // Build table columns for DataTable
            $tableColumns = '';
            $fileFieldSlots = '';

            for ($i = 0; $i < count($data['field_name']); $i++) {
                // Check if this field should be on list page
                if (! empty($data['row_list_page'][$i])) {
                    $fieldName = Str::snake($data['field_name'][$i]);
                    $fieldLabel = Str::title(str_replace('_', ' ', $data['field_name'][$i]));
                    $sortable = ! empty($data['sortable'][$i]) ? 'true' : 'false';

                    $tableColumns .= "{ key: '{$fieldName}', label: '{$fieldLabel}', sortable: {$sortable} },\n    ";

                    // Check if this is a file type field
                    $inputTypeId = $data['input_type'][$i] ?? null;
                    $inputType = $inputTypeId ? ($input_types[$inputTypeId] ?? null) : null;

                    if ($inputType && $inputType->type === 'file') {
                        $fileFieldSlots .= "
                <template #cell-{$fieldName}=\"{ value }\">
                    <img 
                        v-if=\"value\" 
                        :src=\"'/storage/' + value\" 
                        :alt=\"'{$fieldLabel}'\"
                        class=\"h-10 w-10 object-cover rounded\"
                    />
                    <span v-else class=\"text-gray-400\">-</span>
                </template>";
                    } elseif ($inputType && $inputType->type === 'file_multiple') {
                        $fileFieldSlots .= "
                <template #cell-{$fieldName}=\"{ value }\">
                    <div v-if=\"value\" class=\"flex -space-x-2\">
                        <img 
                            v-for=\"(img, idx) in (typeof value === 'string' ? JSON.parse(value) : value).slice(0, 3)\" 
                            :key=\"idx\"
                            :src=\"'/storage/' + img\" 
                            :alt=\"'{$fieldLabel}'\"
                            class=\"h-10 w-10 object-cover rounded border-2 border-white dark:border-gray-800\"
                        />
                        <span 
                            v-if=\"(typeof value === 'string' ? JSON.parse(value) : value).length > 3\" 
                            class=\"flex items-center justify-center h-10 w-10 rounded bg-gray-200 dark:bg-gray-700 text-xs font-medium border-2 border-white dark:border-gray-800\"
                        >
                            +{{ (typeof value === 'string' ? JSON.parse(value) : value).length - 3 }}
                        </span>
                    </div>
                    <span v-else class=\"text-gray-400\">-</span>
                </template>";
                    }
                }
            }

            $modelNamePluralCapital = Str::of($data['model_name'])->plural()->studly();
            $modelNamePluralLower = Str::of($data['model_name'])->plural()->lower();
            $modelNameSingularCapital = Str::of($data['model_name'])->singular()->studly();
            $modelNameSingularLower = Str::of($data['model_name'])->singular()->lower();

            // Generate View button if show_page is enabled
            $viewButton = '';
            if (! empty($data['show_page'])) {
                $viewButton = "                        <LinkButton
                            :href=\"{$modelNamePluralLower}.show(item.id).url\"
                            variant=\"outline-secondary\"
                            size=\"sm\"
                        >
                            View
                        </LinkButton>";
            }

            $viewTemplate = str_replace(
                [
                    '{{ modelNamePluralCapital }}',
                    '{{ modelNamePluralLowerCase }}',
                    '{{ modelNameSingularCapital }}',
                    '{{ modelNameSingularLowerCase }}',
                    '{{ tableColumns }}',
                    '{{ fileFieldSlots }}',
                    '{{ viewButton }}',
                ],
                [
                    $modelNamePluralCapital,
                    $modelNamePluralLower,
                    $modelNameSingularCapital,
                    $modelNameSingularLower,
                    $tableColumns,
                    $fileFieldSlots,
                    $viewButton,
                ],
                file_get_contents(resource_path('stubs/Index.vue.stub'))
            );

            $path = resource_path("js/Pages/{$modelNamePluralCapital}");
            if (! File::exists($path)) {
                File::makeDirectory($path, 0755, true, true);
            }
            file_put_contents($path.'/Index.vue', $viewTemplate);

            // Track generated file
            $this->trackFile('vue_page', "js/Pages/{$modelNamePluralCapital}/Index.vue", 'Index.vue');

            return ['success' => true, 'message' => 'Index page created successfully'];
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function generateCreatePage($data)
    {
        try {
            $input_types = DB::table('crud_input_types')->get()->keyBy('id');

            $formFields = '';
            $formInputs = '';
            $additionalProps = '';
            $optionsDefinitions = '';
            $usedComponents = []; // Track which components are used

            for ($i = 0; $i < count($data['field_name']); $i++) {
                // Check if this field should be on create page
                if (! empty($data['row_create_page'][$i])) {
                    $fieldName = Str::snake($data['field_name'][$i]);
                    $fieldLabel = Str::title(str_replace('_', ' ', $data['field_name'][$i]));
                    $inputTypeId = $data['input_type'][$i];
                    $inputType = $input_types[$inputTypeId] ?? null;
                    $tableRef = $data['table_ref'][$i] ?? null;

                    // Build form field initialization based on type
                    if ($inputType && in_array($inputType->type, ['yes_no', 'true_false'])) {
                        $formFields .= "{$fieldName}: false,\n    ";
                    } elseif ($inputType && in_array($inputType->type, ['select_multiple', 'custom_select_multiple', 'checkboxes', 'custom_checkbox', 'file_multiple'])) {
                        $formFields .= "{$fieldName}: [],\n    ";
                    } else {
                        $formFields .= "{$fieldName}: '',\n    ";
                    }

                    // Build options definitions for select/checkbox/radio fields
                    if ($inputType && in_array($inputType->type, ['select', 'custom_select', 'custom_option', 'select_multiple', 'custom_select_multiple', 'checkboxes', 'custom_checkbox', 'radio', 'custom_radio'])) {
                        // Check if table_ref is set - use props, otherwise check for custom_options
                        if (! empty($tableRef)) {
                            $optionsDefinitions .= "const {$fieldName}Options = props.{$fieldName}Options || [];\n";
                            $additionalProps .= "{$fieldName}Options: {\n        type: Array,\n        default: () => [],\n    },\n    ";
                        } elseif (! empty($data['custom_options'][$i]) && is_array($data['custom_options'][$i]) && count($data['custom_options'][$i]) > 0) {
                            // Build options from custom_options array
                            $optionsArray = [];
                            foreach ($data['custom_options'][$i] as $option) {
                                $value = addslashes($option['value'] ?? '');
                                $label = addslashes($option['label'] ?? '');
                                $optionsArray[] = "{ value: '{$value}', label: '{$label}' }";
                            }
                            $optionsStr = implode(', ', $optionsArray);
                            $optionsDefinitions .= "const {$fieldName}Options = [{$optionsStr}];\n";
                        } else {
                            $optionsDefinitions .= "const {$fieldName}Options = []; // Define options manually or fetch from API\n";
                        }
                    }

                    // Extract mimes validation for file uploads
                    $acceptedMimes = $this->extractMimesFromValidations($data['validations'][$i] ?? []);

                    // Track used components
                    if ($inputType) {
                        $usedComponents[] = $inputType->type;
                        $formInputs .= $this->buildFormInput($fieldName, $fieldLabel, $inputType->type, false, null, $acceptedMimes);
                    }
                }
            }

            // Build dynamic imports based on used components
            $componentImports = $this->buildComponentImports(array_unique($usedComponents));

            $modelNamePluralCapital = Str::of($data['model_name'])->plural()->studly();
            $modelNamePluralLower = Str::of($data['model_name'])->plural()->lower();
            $modelNameSingularCapital = Str::of($data['model_name'])->singular()->studly();
            $modelNameSingularLower = Str::of($data['model_name'])->singular()->lower();

            $createTemplate = str_replace(
                [
                    '{{ modelNamePluralCapital }}',
                    '{{ modelNamePluralLowerCase }}',
                    '{{ modelNameSingularCapital }}',
                    '{{ modelNameSingularLowerCase }}',
                    '{{ formFields }}',
                    '{{ formInputs }}',
                    '{{ additionalProps }}',
                    '{{ optionsDefinitions }}',
                    '{{ componentImports }}',
                ],
                [
                    $modelNamePluralCapital,
                    $modelNamePluralLower,
                    $modelNameSingularCapital,
                    $modelNameSingularLower,
                    $formFields,
                    $formInputs,
                    $additionalProps,
                    $optionsDefinitions,
                    $componentImports,
                ],
                file_get_contents(resource_path('stubs/Create.vue.stub'))
            );

            $path = resource_path("js/Pages/{$modelNamePluralCapital}");
            if (! File::exists($path)) {
                File::makeDirectory($path, 0755, true, true);
            }
            file_put_contents($path.'/Create.vue', $createTemplate);

            // Track generated file
            $this->trackFile('vue_page', "js/Pages/{$modelNamePluralCapital}/Create.vue", 'Create.vue');

            return ['success' => true, 'message' => 'Create page created successfully'];
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function generateEditPage($data)
    {
        try {
            $input_types = DB::table('crud_input_types')->get()->keyBy('id');

            $editFormFields = '';
            $formInputs = '';
            $additionalProps = '';
            $optionsDefinitions = '';
            $usedComponents = []; // Track which components are used
            $modelNameSingularLower = Str::of($data['model_name'])->singular()->lower();

            for ($i = 0; $i < count($data['field_name']); $i++) {
                // Check if this field should be on edit page
                if (! empty($data['row_edit_page'][$i])) {
                    $fieldName = Str::snake($data['field_name'][$i]);
                    $fieldLabel = Str::title(str_replace('_', ' ', $data['field_name'][$i]));
                    $inputTypeId = $data['input_type'][$i];
                    $inputType = $input_types[$inputTypeId] ?? null;
                    $tableRef = $data['table_ref'][$i] ?? null;

                    // Build form field initialization with existing values
                    if ($inputType && in_array($inputType->type, ['yes_no', 'true_false'])) {
                        $editFormFields .= "{$fieldName}: props.{$modelNameSingularLower}.{$fieldName} ?? false,\n    ";
                    } elseif ($inputType && in_array($inputType->type, ['select_multiple', 'custom_select_multiple', 'checkboxes', 'custom_checkbox', 'file_multiple'])) {
                        $editFormFields .= "{$fieldName}: props.{$modelNameSingularLower}.{$fieldName} || [],\n    ";
                    } else {
                        $editFormFields .= "{$fieldName}: props.{$modelNameSingularLower}.{$fieldName} || '',\n    ";
                    }

                    // Build options definitions for select/checkbox/radio fields
                    if ($inputType && in_array($inputType->type, ['select', 'custom_select', 'custom_option', 'select_multiple', 'custom_select_multiple', 'checkboxes', 'custom_checkbox', 'radio', 'custom_radio'])) {
                        // Check if table_ref is set - use props, otherwise check for custom_options
                        if (! empty($tableRef)) {
                            $optionsDefinitions .= "const {$fieldName}Options = props.{$fieldName}Options || [];\n";
                            $additionalProps .= "{$fieldName}Options: {\n        type: Array,\n        default: () => [],\n    },\n    ";
                        } elseif (! empty($data['custom_options'][$i]) && is_array($data['custom_options'][$i]) && count($data['custom_options'][$i]) > 0) {
                            // Build options from custom_options array
                            $optionsArray = [];
                            foreach ($data['custom_options'][$i] as $option) {
                                $value = addslashes($option['value'] ?? '');
                                $label = addslashes($option['label'] ?? '');
                                $optionsArray[] = "{ value: '{$value}', label: '{$label}' }";
                            }
                            $optionsStr = implode(', ', $optionsArray);
                            $optionsDefinitions .= "const {$fieldName}Options = [{$optionsStr}];\n";
                        } else {
                            $optionsDefinitions .= "const {$fieldName}Options = []; // Define options manually or fetch from API\n";
                        }
                    }

                    // Extract mimes validation for file uploads
                    $acceptedMimes = $this->extractMimesFromValidations($data['validations'][$i] ?? []);

                    // Track used components
                    if ($inputType) {
                        $usedComponents[] = $inputType->type;
                        $formInputs .= $this->buildFormInput($fieldName, $fieldLabel, $inputType->type, true, $modelNameSingularLower, $acceptedMimes);
                    }
                }
            }

            // Build dynamic imports based on used components
            $componentImports = $this->buildComponentImports(array_unique($usedComponents));

            $modelNamePluralCapital = Str::of($data['model_name'])->plural()->studly();
            $modelNamePluralLower = Str::of($data['model_name'])->plural()->lower();
            $modelNameSingularCapital = Str::of($data['model_name'])->singular()->studly();

            $editTemplate = str_replace(
                [
                    '{{ modelNamePluralCapital }}',
                    '{{ modelNamePluralLowerCase }}',
                    '{{ modelNameSingularCapital }}',
                    '{{ modelNameSingularLowerCase }}',
                    '{{ editFormFields }}',
                    '{{ formInputs }}',
                    '{{ additionalProps }}',
                    '{{ optionsDefinitions }}',
                    '{{ componentImports }}',
                ],
                [
                    $modelNamePluralCapital,
                    $modelNamePluralLower,
                    $modelNameSingularCapital,
                    $modelNameSingularLower,
                    $editFormFields,
                    $formInputs,
                    $additionalProps,
                    $optionsDefinitions,
                    $componentImports,
                ],
                file_get_contents(resource_path('stubs/Edit.vue.stub'))
            );

            $path = resource_path("js/Pages/{$modelNamePluralCapital}");
            if (! File::exists($path)) {
                File::makeDirectory($path, 0755, true, true);
            }
            file_put_contents($path.'/Edit.vue', $editTemplate);

            // Track generated file
            $this->trackFile('vue_page', "js/Pages/{$modelNamePluralCapital}/Edit.vue", 'Edit.vue');

            return ['success' => true, 'message' => 'Edit page created successfully'];
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Convert file extensions to MIME types for FilePond
     */
    private function extensionsToMimeTypes(string $extensions): array
    {
        $mimeMap = [
            // Images
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'svg' => 'image/svg+xml',
            'bmp' => 'image/bmp',
            'ico' => 'image/x-icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'heic' => 'image/heic',
            'heif' => 'image/heif',
            // Documents
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'odt' => 'application/vnd.oasis.opendocument.text',
            'rtf' => 'application/rtf',
            // Spreadsheets
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
            'csv' => 'text/csv',
            'tsv' => 'text/tab-separated-values',
            // Presentations
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'odp' => 'application/vnd.oasis.opendocument.presentation',
            // Text
            'txt' => 'text/plain',
            'log' => 'text/plain',
            'md' => 'text/markdown',
            // Data formats
            'json' => 'application/json',
            'xml' => 'application/xml',
            'yaml' => 'application/x-yaml',
            'yml' => 'application/x-yaml',
            // Archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            '7z' => 'application/x-7z-compressed',
            'tar' => 'application/x-tar',
            'gz' => 'application/gzip',
            // Audio
            'mp3' => 'audio/mpeg',
            'wav' => 'audio/wav',
            'ogg' => 'audio/ogg',
            'flac' => 'audio/flac',
            'aac' => 'audio/aac',
            'm4a' => 'audio/mp4',
            'wma' => 'audio/x-ms-wma',
            // Video
            'mp4' => 'video/mp4',
            'avi' => 'video/x-msvideo',
            'mov' => 'video/quicktime',
            'wmv' => 'video/x-ms-wmv',
            'mkv' => 'video/x-matroska',
            'webm' => 'video/webm',
            'flv' => 'video/x-flv',
            '3gp' => 'video/3gpp',
            // Code
            'html' => 'text/html',
            'htm' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'php' => 'application/x-httpd-php',
            'sql' => 'application/sql',
            // Fonts
            'ttf' => 'font/ttf',
            'otf' => 'font/otf',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'eot' => 'application/vnd.ms-fontobject',
        ];

        $extArray = array_map('trim', explode(',', strtolower($extensions)));
        $mimeTypes = [];

        foreach ($extArray as $ext) {
            if (isset($mimeMap[$ext])) {
                $mimeTypes[] = $mimeMap[$ext];
            }
        }

        return array_unique($mimeTypes);
    }

    /**
     * Extract mimes validation value from field validations array
     */
    private function extractMimesFromValidations(array $validations): ?string
    {
        // Get the mimes validation ID from database
        $mimesValidation = DB::table('crud_input_validations')->where('validation', 'mimes')->first();
        if (! $mimesValidation) {
            return null;
        }

        foreach ($validations as $validation) {
            if (is_array($validation)) {
                // Format: [validation_id => value]
                $validationId = key($validation);
                if ($validationId == $mimesValidation->id) {
                    return current($validation);
                }
            }
        }

        return null;
    }

    private function buildFormInput($fieldName, $fieldLabel, $inputType, $isEditPage = false, $modelNameSingularLower = null, $acceptedMimes = null)
    {
        switch ($inputType) {
            case 'textarea':
                return "
                    <div class=\"col-span-2\">
                        <FormTextarea
                            v-model=\"form.{$fieldName}\"
                            label=\"{$fieldLabel}\"
                            :error=\"form.errors.{$fieldName}\"
                        />
                    </div>
";
            case 'editor_wysiwyg':
                return "
                    <div class=\"col-span-2\">
                        <label class=\"block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2\">{$fieldLabel}</label>
                        <RichEditor
                            v-model=\"form.{$fieldName}\"
                            :error=\"form.errors.{$fieldName}\"
                        />
                    </div>
";
            case 'number':
                return "
                    <FormInput
                        v-model=\"form.{$fieldName}\"
                        type=\"number\"
                        label=\"{$fieldLabel}\"
                        :error=\"form.errors.{$fieldName}\"
                    />
";
            case 'email':
                return "
                    <FormInput
                        v-model=\"form.{$fieldName}\"
                        type=\"email\"
                        label=\"{$fieldLabel}\"
                        :error=\"form.errors.{$fieldName}\"
                    />
";
            case 'date':
                return "
                    <FormInput
                        v-model=\"form.{$fieldName}\"
                        type=\"date\"
                        label=\"{$fieldLabel}\"
                        :error=\"form.errors.{$fieldName}\"
                    />
";
            case 'datetime':
                return "
                    <FormInput
                        v-model=\"form.{$fieldName}\"
                        type=\"datetime-local\"
                        label=\"{$fieldLabel}\"
                        :error=\"form.errors.{$fieldName}\"
                    />
";
            case 'time':
                return "
                    <FormInput
                        v-model=\"form.{$fieldName}\"
                        type=\"time\"
                        label=\"{$fieldLabel}\"
                        :error=\"form.errors.{$fieldName}\"
                    />
";
            case 'file':
                $existingFilesAttr = $isEditPage && $modelNameSingularLower
                    ? "\n                            :existing-files=\"props.{$modelNameSingularLower}.{$fieldName}\""
                    : '';
                $acceptedTypesAttr = '';
                $allowedExtensionsAttr = '';
                if ($acceptedMimes) {
                    $mimeTypes = $this->extensionsToMimeTypes($acceptedMimes);
                    if (! empty($mimeTypes)) {
                        // Use single quotes inside the array to avoid conflict with attribute double quotes
                        $mimeTypesStr = "['".implode("', '", $mimeTypes)."']";
                        $acceptedTypesAttr = "\n                            :accepted-file-types=\"{$mimeTypesStr}\"";
                    }
                    // Also pass the extensions for backend validation
                    $allowedExtensionsAttr = "\n                            allowed-extensions=\"{$acceptedMimes}\"";
                }

                return "
                    <div class=\"col-span-2\">
                        <FileUpload
                            v-model=\"form.{$fieldName}\"
                            label=\"{$fieldLabel}\"
                            :error=\"form.errors.{$fieldName}\"{$existingFilesAttr}{$acceptedTypesAttr}{$allowedExtensionsAttr}
                        />
                    </div>
";
            case 'file_multiple':
                $existingFilesAttr = $isEditPage && $modelNameSingularLower
                    ? "\n                            :existing-files=\"props.{$modelNameSingularLower}.{$fieldName}\""
                    : '';
                $acceptedTypesAttr = '';
                $allowedExtensionsAttr = '';
                if ($acceptedMimes) {
                    $mimeTypes = $this->extensionsToMimeTypes($acceptedMimes);
                    if (! empty($mimeTypes)) {
                        // Use single quotes inside the array to avoid conflict with attribute double quotes
                        $mimeTypesStr = "['".implode("', '", $mimeTypes)."']";
                        $acceptedTypesAttr = "\n                            :accepted-file-types=\"{$mimeTypesStr}\"";
                    }
                    // Also pass the extensions for backend validation
                    $allowedExtensionsAttr = "\n                            allowed-extensions=\"{$acceptedMimes}\"";
                }

                return "
                    <div class=\"col-span-2\">
                        <FileUpload
                            v-model=\"form.{$fieldName}\"
                            label=\"{$fieldLabel}\"
                            :multiple=\"true\"
                            :error=\"form.errors.{$fieldName}\"{$existingFilesAttr}{$acceptedTypesAttr}{$allowedExtensionsAttr}
                        />
                    </div>
";
            case 'yes_no':
            case 'true_false':
                return "
                    <div class=\"flex items-center\">
                        <label class=\"inline-flex items-center cursor-pointer\">
                            <input type=\"checkbox\" v-model=\"form.{$fieldName}\" class=\"sr-only peer\" />
                            <div class=\"relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600\"></div>
                            <span class=\"ms-3 text-sm font-medium text-gray-900 dark:text-gray-300\">{$fieldLabel}</span>
                        </label>
                    </div>
";
            case 'select':
            case 'custom_select':
            case 'custom_option':
                return "
                    <FormSelect
                        v-model=\"form.{$fieldName}\"
                        label=\"{$fieldLabel}\"
                        :options=\"{$fieldName}Options\"
                        :error=\"form.errors.{$fieldName}\"
                    />
";
            case 'select_multiple':
            case 'custom_select_multiple':
                return "
                    <div>
                        <label class=\"block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2\">{$fieldLabel}</label>
                        <MultiSelect
                            v-model=\"form.{$fieldName}\"
                            :options=\"{$fieldName}Options\"
                            :error=\"form.errors.{$fieldName}\"
                        />
                    </div>
";
            case 'checkboxes':
            case 'custom_checkbox':
                return "
                    <div class=\"col-span-2\">
                        <label class=\"block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2\">{$fieldLabel}</label>
                        <div class=\"flex flex-wrap gap-4\">
                            <label v-for=\"option in {$fieldName}Options\" :key=\"option.value\" class=\"inline-flex items-center\">
                                <input
                                    type=\"checkbox\"
                                    :value=\"option.value\"
                                    v-model=\"form.{$fieldName}\"
                                    class=\"w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600\"
                                />
                                <span class=\"ml-2 text-sm text-gray-900 dark:text-gray-300\">{{ option.label }}</span>
                            </label>
                        </div>
                    </div>
";
            case 'radio':
            case 'custom_radio':
                return "
                    <div class=\"col-span-2\">
                        <label class=\"block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2\">{$fieldLabel}</label>
                        <div class=\"flex flex-wrap gap-4\">
                            <label v-for=\"option in {$fieldName}Options\" :key=\"option.value\" class=\"inline-flex items-center\">
                                <input
                                    type=\"radio\"
                                    :value=\"option.value\"
                                    v-model=\"form.{$fieldName}\"
                                    class=\"w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600\"
                                />
                                <span class=\"ml-2 text-sm text-gray-900 dark:text-gray-300\">{{ option.label }}</span>
                            </label>
                        </div>
                    </div>
";
            case 'text':
            case 'input':
            default:
                return "
                    <FormInput
                        v-model=\"form.{$fieldName}\"
                        label=\"{$fieldLabel}\"
                        :error=\"form.errors.{$fieldName}\"
                    />
";
        }
    }

    private function buildComponentImports(array $usedTypes): string
    {
        $imports = [];

        // Map input types to their required component imports
        $componentMap = [
            // FormInput types
            'input' => 'import FormInput from "@/Components/Form/FormInput.vue";',
            'text' => 'import FormInput from "@/Components/Form/FormInput.vue";',
            'email' => 'import FormInput from "@/Components/Form/FormInput.vue";',
            'number' => 'import FormInput from "@/Components/Form/FormInput.vue";',
            'date' => 'import FormInput from "@/Components/Form/FormInput.vue";',
            'datetime' => 'import FormInput from "@/Components/Form/FormInput.vue";',
            'time' => 'import FormInput from "@/Components/Form/FormInput.vue";',

            // FormTextarea
            'textarea' => 'import FormTextarea from "@/Components/Form/FormTextarea.vue";',

            // RichEditor
            'editor_wysiwyg' => 'import RichEditor from "@/Components/Form/RichEditor.vue";',

            // FileUpload (FilePond based)
            'file' => 'import FileUpload from "@/Components/Form/FileUpload.vue";',
            'file_multiple' => 'import FileUpload from "@/Components/Form/FileUpload.vue";',

            // FormSelect
            'select' => 'import FormSelect from "@/Components/Form/FormSelect.vue";',
            'custom_select' => 'import FormSelect from "@/Components/Form/FormSelect.vue";',
            'custom_option' => 'import FormSelect from "@/Components/Form/FormSelect.vue";',

            // MultiSelect
            'select_multiple' => 'import MultiSelect from "@/Components/Form/MultiSelect.vue";',
            'custom_select_multiple' => 'import MultiSelect from "@/Components/Form/MultiSelect.vue";',

            // Checkboxes (no special import, inline HTML)
            'checkboxes' => '',
            'custom_checkbox' => '',

            // Toggle switch (no special import, inline HTML)
            'yes_no' => '',
            'true_false' => '',
        ];

        foreach ($usedTypes as $type) {
            if (isset($componentMap[$type]) && ! empty($componentMap[$type])) {
                $imports[$componentMap[$type]] = true; // Use as key to dedupe
            }
        }

        return implode("\n", array_keys($imports));
    }

    private function generateShowPage($data)
    {
        try {
            $input_types = DB::table('crud_input_types')->get()->keyBy('id');
            $detailsFields = '';

            for ($i = 0; $i < count($data['field_name']); $i++) {
                // Check if this field should be on details page
                if (! empty($data['row_details_page'][$i])) {
                    $fieldName = Str::snake($data['field_name'][$i]);
                    $fieldLabel = Str::title(str_replace('_', ' ', $data['field_name'][$i]));
                    $modelNameSingularLower = Str::of($data['model_name'])->singular()->lower();

                    // Check if this is a file type field
                    $inputTypeId = $data['input_type'][$i] ?? null;
                    $inputType = $inputTypeId ? ($input_types[$inputTypeId] ?? null) : null;

                    if ($inputType && $inputType->type === 'file') {
                        $detailsFields .= "                <div class=\"bg-gray-50 dark:bg-gray-800/50 rounded-lg p-4\">
                    <dt class=\"text-sm font-medium text-gray-500 dark:text-gray-400 mb-2\">{$fieldLabel}</dt>
                    <dd>
                        <img 
                            v-if=\"{$modelNameSingularLower}.{$fieldName}\" 
                            :src=\"'/storage/' + {$modelNameSingularLower}.{$fieldName}\" 
                            alt=\"{$fieldLabel}\"
                            class=\"max-w-xs rounded-lg shadow-md\"
                        />
                        <span v-else class=\"text-gray-400\">-</span>
                    </dd>
                </div>
";
                    } elseif ($inputType && $inputType->type === 'file_multiple') {
                        $detailsFields .= "                <div class=\"bg-gray-50 dark:bg-gray-800/50 rounded-lg p-4 col-span-2\">
                    <dt class=\"text-sm font-medium text-gray-500 dark:text-gray-400 mb-2\">{$fieldLabel}</dt>
                    <dd>
                        <div v-if=\"{$modelNameSingularLower}.{$fieldName}\" class=\"flex flex-wrap gap-4\">
                            <img 
                                v-for=\"(img, idx) in (typeof {$modelNameSingularLower}.{$fieldName} === 'string' ? JSON.parse({$modelNameSingularLower}.{$fieldName}) : {$modelNameSingularLower}.{$fieldName})\" 
                                :key=\"idx\"
                                :src=\"'/storage/' + img\" 
                                alt=\"{$fieldLabel}\"
                                class=\"h-32 w-32 object-cover rounded-lg shadow-md\"
                            />
                        </div>
                        <span v-else class=\"text-gray-400\">-</span>
                    </dd>
                </div>
";
                    } else {
                        $detailsFields .= "                <div class=\"bg-gray-50 dark:bg-gray-800/50 rounded-lg p-4\">
                    <dt class=\"text-sm font-medium text-gray-500 dark:text-gray-400 mb-1\">{$fieldLabel}</dt>
                    <dd class=\"text-base text-gray-900 dark:text-white\">{{ {$modelNameSingularLower}.{$fieldName} || '-' }}</dd>
                </div>
";
                    }
                }
            }

            $modelNamePluralCapital = Str::of($data['model_name'])->plural()->studly();
            $modelNamePluralLower = Str::of($data['model_name'])->plural()->lower();
            $modelNameSingularCapital = Str::of($data['model_name'])->singular()->studly();
            $modelNameSingularLower = Str::of($data['model_name'])->singular()->lower();

            $showTemplate = str_replace(
                [
                    '{{ modelNamePluralCapital }}',
                    '{{ modelNamePluralLowerCase }}',
                    '{{ modelNameSingularCapital }}',
                    '{{ modelNameSingularLowerCase }}',
                    '{{ detailsFields }}',
                ],
                [
                    $modelNamePluralCapital,
                    $modelNamePluralLower,
                    $modelNameSingularCapital,
                    $modelNameSingularLower,
                    $detailsFields,
                ],
                file_get_contents(resource_path('stubs/Show.vue.stub'))
            );

            $path = resource_path("js/Pages/{$modelNamePluralCapital}");
            if (! File::exists($path)) {
                File::makeDirectory($path, 0755, true, true);
            }
            file_put_contents($path.'/Show.vue', $showTemplate);

            // Track generated file
            $this->trackFile('vue_page', "js/Pages/{$modelNamePluralCapital}/Show.vue", 'Show.vue');

            return ['success' => true, 'message' => 'Show page created successfully'];
        } catch (Exception $e) {
            throw $e;
        }
    }
}
