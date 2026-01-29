<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccessRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('access_update');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'perms' => 'nullable|array',
            'perms.*' => 'exists:permissions,name',
        ];
    }
}
