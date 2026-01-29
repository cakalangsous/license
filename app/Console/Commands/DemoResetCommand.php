<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class DemoResetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:reset {--force : Force the operation without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the demo database and clear uploaded files';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if (!config('app.is_demo')) {
            $this->error('This command can only be run in demo mode. Set IS_DEMO=true in your .env file.');
            return Command::FAILURE;
        }

        if (!$this->option('force') && !$this->confirm('This will reset the entire database and delete all uploaded files. Continue?')) {
            $this->info('Operation cancelled.');
            return Command::SUCCESS;
        }

        $this->info('🔄 Starting demo reset...');

        // Step 1: Clear uploaded media files
        $this->info('📁 Clearing uploaded files...');
        $this->clearUploadedFiles();

        // Step 2: Clear cache
        $this->info('🗑️ Clearing cache...');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');

        // Step 3: Reset database
        $this->info('🗃️ Resetting database...');
        Artisan::call('migrate:fresh', [
            '--seed' => true,
            '--force' => true,
            '--schema-path' => 'do not run schema path',
        ]);

        // Step 4: Run demo seeder for additional demo data
        $this->info('🌱 Seeding demo data...');
        Artisan::call('db:seed', [
            '--class' => 'DemoSeeder',
            '--force' => true,
        ]);

        // Step 5: Recreate storage link
        $this->info('🔗 Recreating storage link...');
        if (File::exists(public_path('storage'))) {
            if (PHP_OS_FAMILY === 'Windows') {
                exec('rmdir "' . public_path('storage') . '"');
            } else {
                File::delete(public_path('storage'));
            }
        }
        Artisan::call('storage:link');

        $this->info('');
        $this->info('✅ Demo reset completed successfully!');
        $this->info('');
        $this->table(
            ['Credential', 'Value'],
            [
                ['Email', 'demo@demo.com'],
                ['Password', 'demo123'],
            ]
        );

        return Command::SUCCESS;
    }

    /**
     * Clear all uploaded files from storage
     */
    protected function clearUploadedFiles(): void
    {
        $directories = [
            storage_path('app/public'),
        ];

        foreach ($directories as $directory) {
            if (File::isDirectory($directory)) {
                // Delete all files and subdirectories, but keep the directory itself
                $files = File::allFiles($directory);
                $subdirs = File::directories($directory);

                foreach ($files as $file) {
                    File::delete($file);
                }

                foreach ($subdirs as $subdir) {
                    File::deleteDirectory($subdir);
                }

                $this->line("  Cleared: {$directory}");
            }
        }
    }
}
