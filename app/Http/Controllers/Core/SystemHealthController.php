<?php

namespace App\Http\Controllers\Core;

use App\Actions\Core\SystemHealth\GetSystemHealth;
use App\Http\Controllers\CoreController;
use Inertia\Response as InertiaResponse;

class SystemHealthController extends CoreController
{
    public function __construct()
    {
        $this->data['parent_menu'] = 'system';
        $this->data['active_menu'] = 'system-health';
        $this->data['title'] = 'System Health';
    }

    /**
     * Display system health check results.
     */
    public function index(): InertiaResponse
    {
        abort_if(! auth()->user()->can('settings_view'), 403);

        $health = (new GetSystemHealth)->execute();

        return inertia('Core/SystemHealth/Index', [
            ...$this->data,
            'health' => $health,
        ]);
    }
}
