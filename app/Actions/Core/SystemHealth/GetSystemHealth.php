<?php

namespace App\Actions\Core\SystemHealth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class GetSystemHealth
{
    /**
     * Run system health checks and return results.
     *
     * @return array
     */
    public function execute(): array
    {
        return [
            'php' => $this->checkPhp(),
            'extensions' => $this->checkExtensions(),
            'directories' => $this->checkDirectories(),
            'database' => $this->checkDatabase(),
            'cache' => $this->checkCache(),
            'queue' => $this->checkQueue(),
            'mail' => $this->checkMail(),
            'storage' => $this->checkStorageLink(),
        ];
    }

    /**
     * Check PHP version.
     */
    protected function checkPhp(): array
    {
        $required = '8.3.0';
        $current = PHP_VERSION;
        $passed = version_compare($current, $required, '>=');

        return [
            'name' => 'PHP Version',
            'required' => ">= {$required}",
            'current' => $current,
            'passed' => $passed,
            'message' => $passed ? 'PHP version is compatible' : "PHP {$required} or higher is required",
        ];
    }

    /**
     * Check required PHP extensions.
     */
    protected function checkExtensions(): array
    {
        $required = [
            'openssl',
            'pdo',
            'mbstring',
            'tokenizer',
            'xml',
            'ctype',
            'json',
            'bcmath',
            'fileinfo',
            'gd',
            'curl',
            'zip',
        ];

        $results = [];
        foreach ($required as $ext) {
            $loaded = extension_loaded($ext);
            $results[] = [
                'name' => $ext,
                'passed' => $loaded,
                'message' => $loaded ? 'Installed' : 'Not installed',
            ];
        }

        return [
            'name' => 'PHP Extensions',
            'items' => $results,
            'passed' => collect($results)->every('passed'),
        ];
    }

    /**
     * Check directory permissions.
     */
    protected function checkDirectories(): array
    {
        $directories = [
            'storage/app' => storage_path('app'),
            'storage/framework' => storage_path('framework'),
            'storage/logs' => storage_path('logs'),
            'bootstrap/cache' => base_path('bootstrap/cache'),
        ];

        $results = [];
        foreach ($directories as $name => $path) {
            $writable = File::isWritable($path);
            $results[] = [
                'name' => $name,
                'path' => $path,
                'passed' => $writable,
                'message' => $writable ? 'Writable' : 'Not writable',
            ];
        }

        return [
            'name' => 'Directory Permissions',
            'items' => $results,
            'passed' => collect($results)->every('passed'),
        ];
    }

    /**
     * Check database connection.
     */
    protected function checkDatabase(): array
    {
        try {
            DB::connection()->getPdo();
            $dbName = DB::connection()->getDatabaseName();

            return [
                'name' => 'Database Connection',
                'passed' => true,
                'current' => config('database.default') . ' (' . $dbName . ')',
                'message' => 'Connection successful',
            ];
        } catch (\Exception $e) {
            return [
                'name' => 'Database Connection',
                'passed' => false,
                'current' => config('database.default'),
                'message' => 'Connection failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Check cache driver.
     */
    protected function checkCache(): array
    {
        try {
            $key = 'health_check_' . time();
            Cache::put($key, 'test', 10);
            $retrieved = Cache::get($key);
            Cache::forget($key);

            $passed = $retrieved === 'test';

            return [
                'name' => 'Cache',
                'passed' => $passed,
                'current' => config('cache.default'),
                'message' => $passed ? 'Working correctly' : 'Cache read/write failed',
            ];
        } catch (\Exception $e) {
            return [
                'name' => 'Cache',
                'passed' => false,
                'current' => config('cache.default'),
                'message' => 'Error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Check queue driver.
     */
    protected function checkQueue(): array
    {
        $driver = config('queue.default');
        $passed = in_array($driver, ['sync', 'database', 'redis', 'beanstalkd', 'sqs']);

        return [
            'name' => 'Queue Driver',
            'passed' => $passed,
            'current' => $driver,
            'message' => $passed ? 'Configured' : 'Unknown driver',
        ];
    }

    /**
     * Check mail configuration.
     */
    protected function checkMail(): array
    {
        $mailer = config('mail.default');
        $host = config('mail.mailers.smtp.host');
        $from = config('mail.from.address');

        $issues = [];
        if (empty($from) || $from === 'hello@example.com') {
            $issues[] = 'From address not configured';
        }
        if ($mailer === 'smtp' && empty($host)) {
            $issues[] = 'SMTP host not configured';
        }

        $passed = empty($issues);

        return [
            'name' => 'Mail Configuration',
            'passed' => $passed,
            'current' => $mailer . ($mailer === 'smtp' ? " ({$host})" : ''),
            'message' => $passed ? 'Configured' : implode(', ', $issues),
        ];
    }

    /**
     * Check storage link.
     */
    protected function checkStorageLink(): array
    {
        $linkPath = public_path('storage');
        $exists = File::isDirectory($linkPath);

        return [
            'name' => 'Storage Link',
            'passed' => $exists,
            'current' => $exists ? 'Linked' : 'Not linked',
            'message' => $exists ? 'Storage link exists' : 'Run: php artisan storage:link',
        ];
    }
}
