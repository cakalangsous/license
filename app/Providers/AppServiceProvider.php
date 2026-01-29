<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Use file-based cache/session during installation (before tables exist)
        if (! $this->isInstalled()) {
            config(['cache.default' => 'file']);
            config(['session.driver' => 'file']);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configure rate limiters
        $this->configureRateLimiting();

        // Configure Password Defaults
        \Illuminate\Validation\Rules\Password::defaults(function () {
            $rule = \Illuminate\Validation\Rules\Password::min(8)
                ->letters()
                ->numbers();

            if ($this->app->isProduction()) {
                $rule
                    ->mixedCase()
                    ->symbols()
                    ->uncompromised();
            }

            return $rule;
        });

        Gate::define('viewScramble', function ($user = null) {
            // Check if site_api_docs_public is enabled
            if (\App\Models\Setting::get('site_api_docs_public')) {
                return true;
            }

            // Otherwise, require authenticated admin
            return $user && ($user->hasRole('Super Admin') || $user->hasRole('Developer'));
        });

        Gate::before(function ($user, $ability) {
            return $user->hasRole('Developer') ? true : null;
        });

        \Dedoc\Scramble\Scramble::afterOpenApiGenerated(function (\Dedoc\Scramble\Support\Generator\OpenApi $openApi) {
            $openApi->secure(
                \Dedoc\Scramble\Support\Generator\SecurityScheme::http('bearer')
            );
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        // Rate limit for login attempts - 5 attempts per minute per IP
        \Illuminate\Support\Facades\RateLimiter::for('login', function (\Illuminate\Http\Request $request) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(5)
                ->by($request->input('email').$request->ip())
                ->response(function () {
                    return back()->withErrors([
                        'email' => 'Too many login attempts. Please try again in a minute.',
                    ]);
                });
        });

        // Rate limit for API requests - 60 per minute per user/IP
        \Illuminate\Support\Facades\RateLimiter::for('api', function (\Illuminate\Http\Request $request) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(60)
                ->by($request->user()?->id ?: $request->ip());
        });

        // Rate limit for password reset - 3 per minute
        \Illuminate\Support\Facades\RateLimiter::for('password-reset', function (\Illuminate\Http\Request $request) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(3)
                ->by($request->input('email').$request->ip());
        });
    }

    /**
     * Check if the application is installed.
     */
    protected function isInstalled(): bool
    {
        // Check if installed file exists or if users table exists
        if (file_exists(storage_path('installed'))) {
            return true;
        }

        try {
            return Schema::hasTable('users');
        } catch (\Exception $e) {
            return false;
        }
    }
}
