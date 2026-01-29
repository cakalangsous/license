<?php

namespace App\Actions\Core\Backup;

use Illuminate\Support\Facades\File;
use ZipArchive;
use Exception;

class CreateFilesBackup
{
    /**
     * Create a files backup (storage/app/public).
     *
     * @return array{success: bool, message: string, filename?: string}
     */
    public function execute(): array
    {
        try {
            $backupPath = storage_path('app/backups');
            $sourcePath = storage_path('app/public');
            
            if (!File::isDirectory($backupPath)) {
                File::makeDirectory($backupPath, 0755, true);
            }

            if (!File::isDirectory($sourcePath)) {
                return [
                    'success' => false,
                    'message' => 'No files to backup in storage/app/public.',
                ];
            }

            $filename = 'files_' . date('Y-m-d_His') . '.zip';
            $filePath = $backupPath . '/' . $filename;

            $zip = new ZipArchive();
            
            if ($zip->open($filePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                throw new Exception('Could not create zip file.');
            }

            $this->addFilesToZip($zip, $sourcePath, 'public');
            
            $zip->close();

            return [
                'success' => true,
                'message' => 'Files backup created successfully.',
                'filename' => $filename,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Backup failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Recursively add files to zip archive.
     */
    protected function addFilesToZip(ZipArchive $zip, string $path, string $relativePath): void
    {
        $files = File::allFiles($path);
        $directories = File::directories($path);

        foreach ($files as $file) {
            $localPath = $relativePath . '/' . $file->getRelativePathname();
            $zip->addFile($file->getRealPath(), $localPath);
        }
    }
}
