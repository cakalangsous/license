<?php

namespace App\Actions\Core\Dashboard;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;
use Spatie\Permission\Models\Role;

class GetDashboardData
{
    public function execute(): array
    {
        return [
            'stats' => $this->getStats(),
            'charts' => $this->getChartData(),
            'recentUsers' => $this->getRecentUsers(),
            'serverInfo' => $this->getServerInfo(),
        ];
    }

    private function getStats(): array
    {
        return [
            'totalUsers' => User::where('email', '!=', 'developer@dev.com')->count(),
            'totalRoles' => Role::where('name', '!=', 'Developer')->count(),
            'totalCruds' => DB::table('cruds')->count(),
            'totalApiTokens' => PersonalAccessToken::count(),
        ];
    }

    private function getChartData(): array
    {
        // User Growth (Last 6 months)
        $usersGrowth = User::select('created_at')
            ->where('email', '!=', 'developer@dev.com')
            ->where('created_at', '>=', now()->subMonths(6))
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($date) {
                return $date->created_at->format('M Y');
            })
            ->map(fn ($row) => $row->count());

        // Roles Distribution
        $rolesDistribution = User::select('id')
            ->where('email', '!=', 'developer@dev.com')
            ->with(['roles' => function ($query) {
                $query->select('name')->where('name', '!=', 'Developer');
            }])
            ->get()
            ->flatMap(function ($user) {
                return $user->roles->pluck('name');
            })
            ->countBy();

        // Handle users with no role
        $usersWithoutRole = User::doesntHave('roles')
            ->where('email', '!=', 'developer@dev.com')
            ->count();

        if ($usersWithoutRole > 0) {
            $rolesDistribution['No Role'] = $usersWithoutRole;
        }

        return [
            'userGrowth' => [
                'labels' => $usersGrowth->keys()->all(),
                'data' => $usersGrowth->values()->all(),
            ],
            'roleDistribution' => [
                'labels' => $rolesDistribution->keys()->all(),
                'data' => $rolesDistribution->values()->all(),
            ],
        ];
    }

    private function getRecentUsers()
    {
        return User::latest()
            ->where('email', '!=', 'developer@dev.com')
            ->take(5)
            ->get(['id', 'name', 'email', 'avatar', 'created_at']);
    }

    private function getServerInfo(): array
    {
        return [
            ['label' => 'PHP', 'value' => phpversion()],
            ['label' => 'Laravel', 'value' => app()->version()],
            ['label' => 'OS', 'value' => PHP_OS],
            ['label' => 'Timezone', 'value' => config('app.timezone')],
            ['label' => 'Debug Mode', 'value' => config('app.debug') ? 'Enabled' : 'Disabled'],
        ];
    }
}
