<?php

namespace App\Providers;

use App\Http\Controllers\InstallerController;
use Froiden\LaravelInstaller\Middleware\canInstall;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class InstallerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->publishes([
            __DIR__.'/../../vendor/froiden/laravel-installer/src/Config/installer.php' => base_path('config/installer.php'),
        ]);

        $this->publishes([
            __DIR__.'/../../vendor/froiden/laravel-installer/src/assets' => public_path('installer'),
        ], 'public');

        $this->publishes([
            __DIR__.'/../../vendor/froiden/laravel-installer/src/Views' => base_path('resources/views/vendor/installer'),
        ]);

        $this->publishes([
            __DIR__.'/../../vendor/froiden/laravel-installer/src/Lang' => base_path('lang'),
        ]);
    }

    /**
     * Bootstrap the application events.
     */
    public function boot(Router $router): void
    {
        $router->middlewareGroup('install', [canInstall::class]);

        // Register installer routes with our custom controllers where needed
        Route::group([
            'prefix' => 'install',
            'as' => 'LaravelInstaller::',
            'middleware' => ['web', 'install'],
        ], function () {
            // Package routes - use original controllers
            Route::get('/', [
                'as' => 'welcome',
                'uses' => '\Froiden\LaravelInstaller\Controllers\WelcomeController@welcome',
            ]);

            Route::get('environment', [
                'as' => 'environment',
                'uses' => '\Froiden\LaravelInstaller\Controllers\EnvironmentController@environment',
            ]);

            Route::get('requirements', [
                'as' => 'requirements',
                'uses' => '\Froiden\LaravelInstaller\Controllers\RequirementsController@requirements',
            ]);

            Route::get('permissions', [
                'as' => 'permissions',
                'uses' => '\Froiden\LaravelInstaller\Controllers\PermissionsController@permissions',
            ]);

            // Custom routes - use our controllers
            Route::get('environment/save', [InstallerController::class, 'saveEnvironment'])
                ->name('environmentSave');

            Route::get('database', [InstallerController::class, 'database'])
                ->name('database');

            Route::post('run-migrations', [InstallerController::class, 'runMigrations'])
                ->name('runMigrations');

            Route::get('final', [InstallerController::class, 'finish'])
                ->name('final');
        });
    }
}
