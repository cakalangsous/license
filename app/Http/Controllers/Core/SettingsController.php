<?php

namespace App\Http\Controllers\Core;

use App\Actions\Core\Settings\GetSettings;
use App\Actions\Core\Settings\RemoveLogo;
use App\Actions\Core\Settings\ResetTheme;
use App\Actions\Core\Settings\SendTestEmail;
use App\Actions\Core\Settings\UpdateApplicationSettings;
use App\Actions\Core\Settings\UpdateEmailSettings;
use App\Actions\Core\Settings\UpdateLicenseSettings;
use App\Actions\Core\Settings\UpdateThemeSettings;
use App\Actions\Core\Settings\UploadLogo;
use App\Http\Controllers\CoreController;
use App\Http\Requests\Core\UpdateApplicationSettingsRequest;
use App\Http\Requests\Core\UpdateThemeSettingsRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response as InertiaResponse;

class SettingsController extends CoreController
{
    public function __construct()
    {
        $this->data['parent_menu'] = 'settings';
        $this->data['active_menu'] = 'settings';
        $this->data['title'] = 'Settings';
    }

    /**
     * Display all settings (combined page with tabs)
     */
    public function index(): InertiaResponse
    {
        abort_if(! auth()->user()->can('settings_view'), 403);

        $settings = (new GetSettings)->execute();

        return inertia('Core/Settings/Index', [
            ...$this->data,
            ...$settings,
        ]);
    }

    /**
     * Display application settings
     *
     * @deprecated Use index() instead
     */
    public function application(): InertiaResponse
    {
        return $this->index();
    }

    /**
     * Update application settings
     */
    public function updateApplication(UpdateApplicationSettingsRequest $request): RedirectResponse
    {
        (new UpdateApplicationSettings)->execute($request->validated());

        return back()->with('success', 'Application settings updated successfully.');
    }

    /**
     * Display theme settings
     *
     * @deprecated Use index() instead
     */
    public function theme(): InertiaResponse
    {
        return $this->index();
    }

    /**
     * Update theme settings
     */
    public function updateTheme(UpdateThemeSettingsRequest $request): RedirectResponse
    {
        (new UpdateThemeSettings)->execute($request->validated());

        return back()->with('success', 'Theme settings updated successfully.');
    }

    /**
     * Update email settings
     */
    public function updateEmail(Request $request): RedirectResponse
    {
        abort_if(! auth()->user()->can('settings_edit'), 403);

        $validated = $request->validate([
            'mail_mailer' => ['required', 'string', 'in:smtp,sendmail,mailgun,ses,postmark,log'],
            'mail_host' => ['nullable', 'string', 'max:255'],
            'mail_port' => ['nullable', 'integer', 'min:1', 'max:65535'],
            'mail_username' => ['nullable', 'string', 'max:255'],
            'mail_password' => ['nullable', 'string', 'max:255'],
            'mail_encryption' => ['nullable', 'string', 'in:tls,ssl,'],
            'mail_from_address' => ['required', 'email', 'max:255'],
            'mail_from_name' => ['required', 'string', 'max:255'],
        ]);

        (new UpdateEmailSettings)->execute($validated);

        return back()->with('success', 'Email settings updated successfully.');
    }

    /**
     * Upload logo
     */
    public function uploadLogo(Request $request): RedirectResponse
    {
        abort_if(! auth()->user()->can('settings_edit'), 403);

        $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'type' => 'required|in:app_logo,app_logo_dark,favicon',
        ]);

        (new UploadLogo)->execute($request->file('logo'), $request->type);

        return back()->with('success', ucfirst(str_replace('_', ' ', $request->type)).' uploaded successfully.');
    }

    /**
     * Remove logo
     */
    public function removeLogo(Request $request): RedirectResponse
    {
        abort_if(! auth()->user()->can('settings_edit'), 403);

        $request->validate([
            'type' => 'required|in:app_logo,app_logo_dark,favicon',
        ]);

        (new RemoveLogo)->execute($request->type);

        return back()->with('success', ucfirst(str_replace('_', ' ', $request->type)).' removed successfully.');
    }

    /**
     * Reset theme settings to defaults
     */
    public function resetTheme(): RedirectResponse
    {
        abort_if(! auth()->user()->can('settings_edit'), 403);

        (new ResetTheme)->execute();

        return back()->with('success', 'Theme settings reset to defaults.');
    }

    /**
     * Send a test email
     */
    public function testEmail(Request $request): \Illuminate\Http\JsonResponse
    {
        abort_if(! auth()->user()->can('settings_edit'), 403);

        $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        $result = (new SendTestEmail)->execute($request->email);

        return response()->json($result, $result['success'] ? 200 : 500);
    }

    /**
     * Update license settings
     */
    public function updateLicense(Request $request): RedirectResponse
    {
        abort_if(! auth()->user()->can('settings_edit'), 403);

        (new UpdateLicenseSettings)->execute($request->all());

        return back()->with('success', 'License settings updated successfully.');
    }
}
