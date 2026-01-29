<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class InstallerController extends BaseController
{
    /**
     * Save database configuration and test connection
     */
    public function saveEnvironment(Request $request): JsonResponse
    {
        $dbHost = $request->get('hostname', '127.0.0.1');
        $dbPort = $request->get('port', '3306');
        $dbName = $request->get('database');
        $dbUsername = $request->get('username', 'root');
        $dbPassword = $request->get('password', '');

        if (empty($dbName)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Database name is required.',
            ]);
        }

        try {
            // Test database connection
            $dsn = "mysql:host={$dbHost};port={$dbPort}";
            $pdo = new \PDO($dsn, $dbUsername, $dbPassword);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            // Create database if not exists
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

            // Update .env file
            $this->updateEnvFile([
                'DB_HOST' => $dbHost,
                'DB_PORT' => $dbPort,
                'DB_DATABASE' => $dbName,
                'DB_USERNAME' => $dbUsername,
                'DB_PASSWORD' => $dbPassword,
                'APP_URL' => $request->getSchemeAndHttpHost(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Database connection successful!',
            ]);

        } catch (\PDOException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Database connection failed: '.$e->getMessage(),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Error: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Update .env file with new values
     */
    protected function updateEnvFile(array $data): void
    {
        $envPath = base_path('.env');
        $envExamplePath = base_path('.env.example');

        // Create .env from .env.example if it doesn't exist
        if (! file_exists($envPath)) {
            if (file_exists($envExamplePath)) {
                copy($envExamplePath, $envPath);
            } else {
                touch($envPath);
            }
        }

        $envContent = file_get_contents($envPath);

        foreach ($data as $key => $value) {
            // Escape quotes in value
            $value = str_replace('"', '\"', $value);

            // Check if key exists
            if (preg_match("/^{$key}=.*/m", $envContent)) {
                // Update existing key
                $envContent = preg_replace("/^{$key}=.*/m", "{$key}=\"{$value}\"", $envContent);
            } else {
                // Add new key
                $envContent .= "\n{$key}=\"{$value}\"";
            }
        }

        file_put_contents($envPath, $envContent);
    }

    /**
     * Run migrations and seeders via AJAX
     */
    public function runMigrations(): JsonResponse
    {
        set_time_limit(0);

        try {
            // Step 1: Run migrations
            Artisan::call('migrate:fresh', [
                '--force' => true,
                '--schema-path' => 'do not run schema path',
            ]);

            // Step 2: Run seeders
            Artisan::call('db:seed', ['--force' => true]);

            // Step 3: Generate app key if not set
            if (empty(config('app.key'))) {
                Artisan::call('key:generate', ['--force' => true]);
            }

            // Step 4: Clear and cache config
            Artisan::call('config:clear');
            Artisan::call('cache:clear');

            return response()->json([
                'status' => 'success',
                'message' => 'Installation completed successfully!',
            ]);
        } catch (Exception $e) {
            Log::error('Installation failed: '.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the database setup page
     */
    public function database()
    {
        return view('vendor.installer.database');
    }

    /**
     * Finalize installation
     */
    public function finish()
    {
        // Create installed file
        $installedFile = storage_path('installed');
        if (! file_exists($installedFile)) {
            file_put_contents($installedFile, date('Y-m-d H:i:s'));
        }

        return view('vendor.installer.finished');
    }
}
