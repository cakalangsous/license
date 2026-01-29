<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApplicationSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('settings_edit');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'app_name' => 'required|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'site_api_docs_public' => 'boolean',
        ];
    }
}
