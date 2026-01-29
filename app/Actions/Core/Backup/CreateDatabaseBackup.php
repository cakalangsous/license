<?php

namespace App\Actions\Core\Backup;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Exception;

class CreateDatabaseBackup
{
    /**
     * Create a database backup (SQL dump).
     *
     * @return array{success: bool, message: string, filename?: string}
     */
    public function execute(): array
    {
        try {
            $backupPath = storage_path('app/backups');
            
            if (!File::isDirectory($backupPath)) {
                File::makeDirectory($backupPath, 0755, true);
            }

            $filename = 'database_' . date('Y-m-d_His') . '.sql';
            $filePath = $backupPath . '/' . $filename;

            $connection = config('database.default');
            $driver = config("database.connections.{$connection}.driver");

            if ($driver === 'mysql') {
                $this->backupMysql($filePath);
            } elseif ($driver === 'pgsql') {
                $this->backupPostgres($filePath);
            } elseif ($driver === 'sqlite') {
                $this->backupSqlite($filePath);
            } else {
                return [
                    'success' => false,
                    'message' => "Database driver '{$driver}' is not supported for backup.",
                ];
            }

            return [
                'success' => true,
                'message' => 'Database backup created successfully.',
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
     * Backup MySQL database.
     */
    protected function backupMysql(string $filePath): void
    {
        $connection = config('database.default');
        $host = config("database.connections.{$connection}.host");
        $port = config("database.connections.{$connection}.port");
        $database = config("database.connections.{$connection}.database");
        $username = config("database.connections.{$connection}.username");
        $password = config("database.connections.{$connection}.password");

        $command = sprintf(
            'mysqldump --host=%s --port=%s --user=%s --password=%s %s > %s 2>&1',
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($database),
            escapeshellarg($filePath)
        );

        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            throw new Exception('mysqldump failed: ' . implode("\n", $output));
        }
    }

    /**
     * Backup PostgreSQL database.
     */
    protected function backupPostgres(string $filePath): void
    {
        $connection = config('database.default');
        $host = config("database.connections.{$connection}.host");
        $port = config("database.connections.{$connection}.port");
        $database = config("database.connections.{$connection}.database");
        $username = config("database.connections.{$connection}.username");
        $password = config("database.connections.{$connection}.password");

        // Set password environment variable
        putenv("PGPASSWORD={$password}");

        $command = sprintf(
            'pg_dump --host=%s --port=%s --username=%s %s > %s 2>&1',
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($username),
            escapeshellarg($database),
            escapeshellarg($filePath)
        );

        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            throw new Exception('pg_dump failed: ' . implode("\n", $output));
        }
    }

    /**
     * Backup SQLite database.
     */
    protected function backupSqlite(string $filePath): void
    {
        $connection = config('database.default');
        $database = config("database.connections.{$connection}.database");

        // For SQLite, just copy the database file
        if (!File::exists($database)) {
            throw new Exception('SQLite database file not found.');
        }

        // Read the database and dump as SQL
        $pdo = DB::connection()->getPdo();
        
        $sql = "";
        
        // Get all tables
        $tables = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'")->fetchAll();
        
        foreach ($tables as $table) {
            $tableName = $table['name'];
            
            // Get CREATE TABLE statement
            $createStmt = $pdo->query("SELECT sql FROM sqlite_master WHERE type='table' AND name='{$tableName}'")->fetch();
            $sql .= $createStmt['sql'] . ";\n\n";
            
            // Get all data
            $rows = $pdo->query("SELECT * FROM {$tableName}")->fetchAll(\PDO::FETCH_ASSOC);
            
            foreach ($rows as $row) {
                $columns = implode(', ', array_keys($row));
                $values = implode(', ', array_map(fn($v) => $pdo->quote($v ?? ''), array_values($row)));
                $sql .= "INSERT INTO {$tableName} ({$columns}) VALUES ({$values});\n";
            }
            
            $sql .= "\n";
        }

        File::put($filePath, $sql);
    }
}
