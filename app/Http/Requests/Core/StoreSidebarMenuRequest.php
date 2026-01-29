<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;

class StoreSidebarMenuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'route_name' => 'nullable|string|max:255',
            'section' => 'required|string|max:255',
            'permission' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:sidebar_menus,id',
            'is_active' => 'boolean',
        ];
    }
}
