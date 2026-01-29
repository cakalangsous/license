<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use App\Models\SidebarMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'csrf_token' => csrf_token(),
            'auth' => [
                'user' => $request->user() ? [
                    'id' => $request->user()->id,
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                    'avatar' => $request->user()->avatar,
                ] : null,
                'roles' => $request->user()?->getRoleNames()->toArray() ?? [],
                'permissions' => $request->user()?->hasRole('Developer')
                    ? \Spatie\Permission\Models\Permission::all()->pluck('name')->toArray()
                    : ($request->user()?->getAllPermissions()->pluck('name')->toArray() ?? []),
            ],
            'flash' => array_merge([
                'success' => $request->session()->get('success'),
                'message' => $request->session()->get('message'),
                'error' => $request->session()->get('error'),
            ], (array) $request->session()->get('flash', [])),
            'appName' => Setting::get('app_name', config('app.name')),
            'appLogo' => $this->getStorageUrl(Setting::get('app_logo')),
            'appLogoDark' => $this->getStorageUrl(Setting::get('app_logo_dark')),
            'dynamicMenus' => $this->getDynamicMenus(),
            'domain' => $request->root(),
            'appVersion' => config('app.version', '1.0.0'),
            'updateInfo' => $this->getUpdateInfo($request),
            'isDemo' => config('app.is_demo', false),
        ];
    }

    /**
     * Get update information (only for admin users with settings permission).
     */
    protected function getUpdateInfo(Request $request): ?array
    {
        // Only check for updates if user has settings permission
        if (!$request->user() || !$request->user()->can('settings_view')) {
            return null;
        }

        try {
            return (new \App\Actions\Core\Update\CheckForUpdates)->execute();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Convert a storage path to a full URL.
     */
    protected function getStorageUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        // If it's already a full URL, return as-is
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')) {
            return $path;
        }

        return '/storage/'.$path;
    }

    /**
     * Get dynamic sidebar menus from database.
     */
    protected function getDynamicMenus(): array
    {
        // Check if table exists to prevent errors during migration
        if (! Schema::hasTable('sidebar_menus')) {
            return [];
        }

        $menus = SidebarMenu::roots()
            ->where('is_active', true)
            ->with(['children' => function ($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('section')
            ->orderBy('order')
            ->get();

        return $menus->groupBy('section')->map(function ($items, $section) {
            return [
                'title' => $section,
                'items' => $items->map(function ($item) {
                    $menuItem = [
                        'name' => $item->title,
                        'href' => $this->resolveRoute($item->route_name),
                        'icon' => $item->icon,
                        'permission' => $item->permission,
                    ];

                    if ($item->children->isNotEmpty()) {
                        $menuItem['children'] = $item->children->map(function ($child) {
                            return [
                                'name' => $child->title,
                                'href' => $this->resolveRoute($child->route_name),
                                'permission' => $child->permission,
                            ];
                        })->toArray();
                    }

                    return $menuItem;
                })->toArray(),
            ];
        })->values()->toArray();
    }

    /**
     * Resolve route name to URL.
     */
    protected function resolveRoute(string $routeName): string
    {
        try {
            if (Route::has($routeName)) {
                $url = route($routeName);

                // Extract just the path (without domain) for proper comparison with page.url
                return parse_url($url, PHP_URL_PATH) ?: $url;
            }

            return '#';
        } catch (\Exception $e) {
            return '#';
        }
    }
}
