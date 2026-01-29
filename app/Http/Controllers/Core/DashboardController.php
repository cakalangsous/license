<?php

namespace App\Http\Controllers\Core;

use App\Actions\Core\Dashboard\GetDashboardData;
use App\Http\Controllers\CoreController;
use Inertia\Response as InertiaResponse;

class DashboardController extends CoreController
{
    public function __construct()
    {
        $this->data['active_menu'] = 'dashboard';
        $this->data['title'] = 'Dashboard';
    }

    public function index(): InertiaResponse
    {
        $dashboardData = (new GetDashboardData)->execute();

        return $this->inertia('Core/Dashboard', [
            'title' => 'Dashboard',
            ...$dashboardData,
        ]);
    }
}
