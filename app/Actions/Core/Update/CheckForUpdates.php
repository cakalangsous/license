<?php

namespace App\Actions\Core\Update;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Exception;

class CheckForUpdates
{
    /**
     * Check for application updates.
     * 
     * This compares the local version with a remote version file.
     * For production, you would host a version.json file on your server.
     *
     * @return array
     */
    public function execute(): array
    {
        $currentVersion = config('app.version', '1.0.0');
        
        // Cache the update check for 24 hours to avoid excessive requests
        return Cache::remember('laraku_update_check', 60 * 60 * 24, function () use ($currentVersion) {
            return $this->checkRemoteVersion($currentVersion);
        });
    }

    /**
     * Force check for updates (bypass cache).
     *
     * @return array
     */
    public function forceCheck(): array
    {
        Cache::forget('laraku_update_check');
        return $this->execute();
    }

    /**
     * Check the remote version.
     */
    protected function checkRemoteVersion(string $currentVersion): array
    {
        try {
            // For production, replace with your actual update server URL
            $updateUrl = config('app.update_url', null);
            
            if (!$updateUrl) {
                // No update URL configured, return current version info
                return [
                    'current_version' => $currentVersion,
                    'latest_version' => $currentVersion,
                    'update_available' => false,
                    'changelog_url' => null,
                    'download_url' => null,
                    'checked_at' => now()->toIso8601String(),
                    'message' => 'Update checking is not configured.',
                ];
            }

            $response = Http::timeout(10)->get($updateUrl);
            
            if (!$response->successful()) {
                throw new Exception('Failed to fetch update information.');
            }

            $data = $response->json();
            $latestVersion = $data['version'] ?? $currentVersion;
            $updateAvailable = version_compare($latestVersion, $currentVersion, '>');

            return [
                'current_version' => $currentVersion,
                'latest_version' => $latestVersion,
                'update_available' => $updateAvailable,
                'changelog_url' => $data['changelog_url'] ?? null,
                'download_url' => $data['download_url'] ?? null,
                'release_notes' => $data['release_notes'] ?? null,
                'checked_at' => now()->toIso8601String(),
                'message' => $updateAvailable 
                    ? "A new version ({$latestVersion}) is available!" 
                    : 'You are running the latest version.',
            ];
        } catch (Exception $e) {
            return [
                'current_version' => $currentVersion,
                'latest_version' => $currentVersion,
                'update_available' => false,
                'changelog_url' => null,
                'download_url' => null,
                'checked_at' => now()->toIso8601String(),
                'message' => 'Could not check for updates: ' . $e->getMessage(),
                'error' => true,
            ];
        }
    }
}
