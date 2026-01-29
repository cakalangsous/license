<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DemoModeMiddleware
{
    /**
     * Routes that are restricted in demo mode (POST/PUT/DELETE methods)
     */
    protected array $restrictedRoutes = [
        // Prevent password changes
        'admin.profile.password.update',
        'admin.users.update-password',
        
        // Prevent deleting core data
        'admin.users.destroy',
        'admin.roles.destroy',
        'admin.permissions.destroy',
        
        // Prevent critical settings changes
        'admin.settings.save',
        
        // Prevent backup operations that could be abused
        'admin.backups.create',
        'admin.backups.download',
        
        // Prevent sidebar menu deletion
        'admin.sidebar-menu.destroy',
    ];

    /**
     * Protected user emails that cannot be modified
     */
    protected array $protectedEmails = [
        'admin@admin.com',
        'demo@demo.com',
        'developer@dev.com',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only apply restrictions in demo mode
        if (!config('app.is_demo')) {
            return $next($request);
        }

        // Check if route is restricted
        $routeName = $request->route()?->getName();
        
        if ($this->isRestrictedRoute($routeName, $request)) {
            return $this->demoRestrictionResponse($request);
        }

        // Protect specific users from modification
        if ($this->isProtectedUserModification($request)) {
            return $this->demoRestrictionResponse($request, 'This user cannot be modified in demo mode.');
        }

        return $next($request);
    }

    /**
     * Check if the route is restricted in demo mode
     */
    protected function isRestrictedRoute(?string $routeName, Request $request): bool
    {
        if (!$routeName) {
            return false;
        }

        // Only restrict modification methods
        if (!in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            return false;
        }

        return in_array($routeName, $this->restrictedRoutes);
    }

    /**
     * Check if trying to modify a protected user
     */
    protected function isProtectedUserModification(Request $request): bool
    {
        // Check for user update/delete operations
        $routeName = $request->route()?->getName();
        
        if (!in_array($routeName, ['admin.users.update', 'admin.users.destroy'])) {
            return false;
        }

        $userId = $request->route('user');
        
        if (!$userId) {
            return false;
        }

        $user = \App\Models\User::find($userId);
        
        return $user && in_array($user->email, $this->protectedEmails);
    }

    /**
     * Return demo restriction response
     */
    protected function demoRestrictionResponse(Request $request, ?string $message = null): Response
    {
        $message = $message ?? 'This action is restricted in demo mode.';

        if ($request->expectsJson() || $request->header('X-Inertia')) {
            return back()->with('error', $message);
        }

        abort(403, $message);
    }
}
