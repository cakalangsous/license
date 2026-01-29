<?php

namespace App\Actions\Core\Permission;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class GetFilteredPermissions
{
    private array $excludedTables = [
        'commentables',
        'crud_input_types',
        'crud_input_validations',
        'failed_jobs',
        'migrations',
        'model_has_permissions',
        'model_has_roles',
        'password_reset_tokens',
        'personal_access_tokens',
        'role_has_permissions',
        'taggables',
        'temporary_files',
    ];

    public function execute(Request $request): array
    {
        $query = Permission::orderByDesc('id');

        // Handle search
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('table_name', 'like', "%{$search}%")
                    ->orWhere('guard_name', 'like', "%{$search}%");
            });
        }

        // Handle sorting
        if ($request->sort) {
            $direction = $request->direction === 'desc' ? 'desc' : 'asc';
            $query->reorder($request->sort, $direction);
        }

        $perPage = $request->per_page ?? 10;
        $paginatedPermissions = $query->paginate($perPage)->withQueryString();

        // Get available tables
        $tables = DB::select('SHOW TABLES');
        $tables = array_map('current', $tables);
        $availableTables = array_values(array_diff($tables, $this->excludedTables));

        return [
            'paginatedPermissions' => $paginatedPermissions,
            'tables' => $availableTables,
        ];
    }
}
