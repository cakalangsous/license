<?php

namespace App\Http\Controllers\Core;

use App\Actions\Core\Profile\UpdatePassword;
use App\Actions\Core\Profile\UpdateProfile;
use App\Http\Controllers\CoreController;
use App\Http\Requests\Core\UpdatePasswordRequest;
use App\Http\Requests\Core\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class ProfileController extends CoreController
{
    public function __construct()
    {
        $this->data['active_menu'] = 'profile';
        $this->data['title'] = 'My Profile';
    }

    /**
     * Show the form for editing the profile.
     */
    public function edit(): Response
    {
        $this->data['user'] = auth()->user();
        $this->data['timezones'] = \DateTimeZone::listIdentifiers();
        $this->data['locales'] = ['en' => 'English', 'es' => 'Spanish', 'fr' => 'French', 'de' => 'German']; // Example locales

        return $this->inertia('Core/Profile/Edit', $this->data);
    }

    /**
     * Update the profile.
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = auth()->user();

        (new UpdateProfile)->execute($user, $request->validated(), $request->filepond);

        return back()->with(['success' => true, 'message' => 'Profile updated successfully!']);
    }

    /**
     * Update Password.
     */
    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        (new UpdatePassword)->execute(auth()->user(), $request->password);

        auth()->user()->notify(new \App\Notifications\SystemNotification('Security Alert', 'Your password was updated.', null, 'warning'));

        return back()->with(['success' => true, 'message' => 'Password updated successfully!']);
    }
}
