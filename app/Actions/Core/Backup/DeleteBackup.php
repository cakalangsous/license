<?php

namespace App\Actions\Core\Backup;

use Illuminate\Support\Facades\File;

class DeleteBackup
{
    /**
     * Delete a backup file.
     *
     * @param string $filename
     * @return array{success: bool, message: string}
     */
    public function execute(string $filename): array
    {
        $backupPath = storage_path('app/backups');
        $filePath = $backupPath . '/' . basename($filename);

        if (!File::exists($filePath)) {
            return [
                'success' => false,
                'message' => 'Backup file not found.',
            ];
        }

        // Security check: ensure file is in backups directory
        $realPath = realpath($filePath);
        $realBackupPath = realpath($backupPath);
        
        if (!$realPath || !$realBackupPath || strpos($realPath, $realBackupPath) !== 0) {
            return [
                'success' => false,
                'message' => 'Invalid backup file path.',
            ];
        }

        File::delete($filePath);

        return [
            'success' => true,
            'message' => 'Backup deleted successfully.',
        ];
    }
}
