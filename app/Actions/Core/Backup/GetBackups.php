<?php

namespace App\Actions\Core\Backup;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class GetBackups
{
    /**
     * Get list of all backups.
     *
     * @return array
     */
    public function execute(): array
    {
        $backupPath = storage_path('app/backups');
        
        if (!File::isDirectory($backupPath)) {
            File::makeDirectory($backupPath, 0755, true);
            return [];
        }

        $files = File::files($backupPath);
        $backups = [];

        foreach ($files as $file) {
            $filename = $file->getFilename();
            $extension = $file->getExtension();
            
            // Determine type based on filename pattern
            $type = 'unknown';
            if (str_contains($filename, 'database_')) {
                $type = 'database';
            } elseif (str_contains($filename, 'files_')) {
                $type = 'files';
            }

            $backups[] = [
                'filename' => $filename,
                'type' => $type,
                'size' => $this->formatBytes($file->getSize()),
                'size_bytes' => $file->getSize(),
                'created_at' => date('Y-m-d H:i:s', $file->getMTime()),
                'extension' => $extension,
            ];
        }

        // Sort by creation date descending
        usort($backups, fn($a, $b) => strtotime($b['created_at']) - strtotime($a['created_at']));

        return $backups;
    }

    /**
     * Format bytes to human readable format.
     */
    protected function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.2f %s", $bytes / pow(1024, $factor), $units[$factor]);
    }
}
