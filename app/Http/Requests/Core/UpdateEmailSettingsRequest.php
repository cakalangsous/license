<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmailSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('settings_edit') ?? false;
    }

    public function rules(): array
    {
        return [
            'mail_mailer' => ['required', 'string', 'in:smtp,sendmail,mailgun,ses,postmark,log'],
            'mail_host' => ['nullable', 'string', 'max:255'],
            'mail_port' => ['nullable', 'integer', 'min:1', 'max:65535'],
            'mail_username' => ['nullable', 'string', 'max:255'],
            'mail_password' => ['nullable', 'string', 'max:255'],
            'mail_encryption' => ['nullable', 'string', 'in:tls,ssl,'],
            'mail_from_address' => ['required', 'email', 'max:255'],
            'mail_from_name' => ['required', 'string', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'mail_mailer' => 'Mail Driver',
            'mail_host' => 'SMTP Host',
            'mail_port' => 'SMTP Port',
            'mail_username' => 'SMTP Username',
            'mail_password' => 'SMTP Password',
            'mail_encryption' => 'Encryption',
            'mail_from_address' => 'From Address',
            'mail_from_name' => 'From Name',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Convert port to integer if provided
        if ($this->has('mail_port') && $this->mail_port !== null) {
            $this->merge([
                'mail_port' => (int) $this->mail_port,
            ]);
        }
    }
}
