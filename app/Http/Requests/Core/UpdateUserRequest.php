<?php

namespace App\Http\Requests\Core;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->route('user');

        // Can't edit user ID 1 unless you are user ID 1
        if ($user->id == 1 && auth()->user()->id != 1) {
            return false;
        }

        return $this->user()->can('users_update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $user = $this->route('user');

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'avatar' => 'nullable|image|file|max:2048',
            'password' => 'nullable',
            'password_confirmation' => 'nullable|same:password',
            'filepond' => 'nullable|string',
        ];

        // Only require roles if user doesn't have Developer role
        if (!$user->hasRole('Developer')) {
            $rules['roles'] = 'required';
        }

        return $rules;
    }
}
