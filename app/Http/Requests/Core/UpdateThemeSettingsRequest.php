<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;

class UpdateThemeSettingsRequest extends FormRequest
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
            'primary_color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            'secondary_color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            'success_color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            'danger_color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            'warning_color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            'info_color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            'light_bg_color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            'dark_bg_color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            'sidebar_bg_light' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            'sidebar_bg_dark' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
        ];
    }
}
