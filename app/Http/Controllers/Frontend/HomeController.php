<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Setting;
use Inertia\Response as InertiaResponse;

class HomeController extends FrontendController
{
    public function index(): InertiaResponse
    {
        $this->data['features'] = $this->getFeatures();

        return $this->inertia('Frontend/Home');
    }

    private function getFeatures(): array
    {
        return [
            [
                'icon' => 'ShieldCheckIcon',
                'title' => 'Role & Permission',
                'description' => 'Complete role-based access control with granular permissions for every feature.',
            ],
            [
                'icon' => 'WrenchScrewdriverIcon',
                'title' => 'CRUD Builder',
                'description' => 'Generate complete CRUD operations instantly with just a few clicks.',
            ],
            [
                'icon' => 'PaintBrushIcon',
                'title' => 'Theme Customization',
                'description' => 'Customize colors, fonts, and logo to match your brand perfectly.',
            ],
            [
                'icon' => 'DocumentTextIcon',
                'title' => 'Blog Management',
                'description' => 'Built-in blog system with categories, tags, and rich text editor.',
            ],
            [
                'icon' => 'BellIcon',
                'title' => 'Notifications',
                'description' => 'Real-time notification system to keep users informed.',
            ],
            [
                'icon' => 'ArchiveBoxIcon',
                'title' => 'Action Pattern Architecture',
                'description' => 'Clean, testable, and reusable business logic encapsulated in single-purpose Action classes.',
            ],
            [
                'icon' => 'UserGroupIcon',
                'title' => 'User Management',
                'description' => 'Complete user management with profiles, 2FA, and activity logs.',
            ],
            [
                'icon' => 'Cog6ToothIcon',
                'title' => 'Dynamic Settings',
                'description' => 'Easily configurable application settings without touching code.',
            ],
            [
                'icon' => 'PhotoIcon',
                'title' => 'Media Library',
                'description' => 'Upload and manage images with an integrated media picker.',
            ],
            [
                'icon' => 'Bars3Icon',
                'title' => 'Dynamic Sidebar',
                'description' => 'Drag and drop sidebar menu builder for easy navigation.',
            ],
            [
                'icon' => 'KeyIcon',
                'title' => 'API Tokens',
                'description' => 'Secure API token management for external integrations.',
            ],
        ];
    }
}
