<?php

namespace App\Http\Requests\Core;

use App\Enum\CrudBuilderOption;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCrudRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasRole('Developer');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'model_name' => ['required'],
            'table_name' => ['required'],
            'builder_options' => ['required', Rule::enum(CrudBuilderOption::class)],
            'soft_deletes' => ['sometimes', 'boolean'],
            'create_page' => ['sometimes', 'boolean'],
            'edit_page' => ['sometimes', 'boolean'],
            'show_page' => ['sometimes', 'boolean'],
            'field_name' => ['required', 'array', 'min:1'],
            'field_type' => ['required', 'array', 'min:1'],
            'default_value' => ['required', 'array', 'min:1'],
            'defined_value' => ['required', 'array', 'min:1'],
            'input_type' => ['required', 'array', 'min:1'],
            'validations' => ['required', 'array', 'min:1'],
            'row_create_page' => ['sometimes', 'array', 'min:1'],
            'row_edit_page' => ['sometimes', 'array', 'min:1'],
            'row_list_page' => ['sometimes', 'array', 'min:1'],
            'row_details_page' => ['sometimes', 'array', 'min:1'],
            'searchable' => ['sometimes', 'array', 'min:1'],
            'sortable' => ['sometimes', 'array', 'min:1'],
            'table_ref' => ['sometimes', 'array'],
            'table_ref.*' => ['nullable', 'string'],
            'value_field_ref' => ['sometimes', 'array'],
            'value_field_ref.*' => ['nullable', 'string'],
            'label_field_ref' => ['sometimes', 'array'],
            'label_field_ref.*' => ['nullable', 'string'],
            'where_field_ref' => ['sometimes', 'array'],
            'where_field_ref.*' => ['nullable', 'string'],
            'custom_options' => ['sometimes', 'array'],
            'custom_options.*' => ['sometimes', 'array'],
            'custom_options.*.*.value' => ['nullable', 'string'],
            'custom_options.*.*.label' => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'soft_deletes' => filter_var($this->input('soft_deletes', 'false'), FILTER_VALIDATE_BOOLEAN),
            'create_page' => filter_var($this->input('create_page', 'false'), FILTER_VALIDATE_BOOLEAN),
            'edit_page' => filter_var($this->input('edit_page', 'false'), FILTER_VALIDATE_BOOLEAN),
            'show_page' => filter_var($this->input('show_page', 'false'), FILTER_VALIDATE_BOOLEAN),
            'row_create_page.*' => 'boolean',
            'row_edit_page.*' => 'boolean',
            'row_list_page.*' => 'boolean',
            'row_details_page.*' => 'boolean',
            'searchable.*' => 'boolean',
            'sortable.*' => 'boolean',
        ]);
    }
}
