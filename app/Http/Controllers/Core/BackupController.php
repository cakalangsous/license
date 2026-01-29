<?php

namespace App\Http\Controllers\Core;

use App\Actions\Core\Backup\CreateDatabaseBackup;
use App\Actions\Core\Backup\CreateFilesBackup;
use App\Actions\Core\Backup\DeleteBackup;
use App\Actions\Core\Backup\GetBackups;
use App\Http\Controllers\CoreController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Inertia\Response as InertiaResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BackupController extends CoreController
{
    public function __construct()
    {
        $this->data['parent_menu'] = 'system';
        $this->data['active_menu'] = 'backup';
        $this->data['title'] = 'Backup';
    }

    /**
     * Display backup management page.
     */
    public function index(): InertiaResponse
    {
        abort_if(! auth()->user()->can('settings_edit'), 403);

        $backups = (new GetBackups)->execute();

        return inertia('Core/Backup/Index', [
            ...$this->data,
            'backups' => $backups,
        ]);
    }

    /**
     * Create database backup.
     */
    public function createDatabase(): JsonResponse
    {
        abort_if(! auth()->user()->can('settings_edit'), 403);

        $result = (new CreateDatabaseBackup)->execute();

        return response()->json($result, $result['success'] ? 200 : 500);
    }

    /**
     * Create files backup.
     */
    public function createFiles(): JsonResponse
    {
        abort_if(! auth()->user()->can('settings_edit'), 403);

        $result = (new CreateFilesBackup)->execute();

        return response()->json($result, $result['success'] ? 200 : 500);
    }

    /**
     * Download a backup file.
     */
    public function download(string $filename): BinaryFileResponse
    {
        abort_if(! auth()->user()->can('settings_edit'), 403);

        $backupPath = storage_path('app/backups');
        $filePath = $backupPath . '/' . basename($filename);

        // Security check
        $realPath = realpath($filePath);
        $realBackupPath = realpath($backupPath);
        
        if (!$realPath || !$realBackupPath || strpos($realPath, $realBackupPath) !== 0 || !File::exists($realPath)) {
            abort(404, 'Backup file not found.');
        }

        return response()->download($realPath, $filename);
    }

    /**
     * Delete a backup file.
     */
    public function destroy(string $filename): JsonResponse
    {
        abort_if(! auth()->user()->can('settings_edit'), 403);

        $result = (new DeleteBackup)->execute($filename);

        return response()->json($result, $result['success'] ? 200 : 404);
    }
}
