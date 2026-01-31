<?php

namespace App\Http\Controllers\Core;

use App\Actions\Core\Sale\GetFilteredSales;
use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use Inertia\Response as InertiaResponse;

class SaleController extends CoreController
{
    public function __construct()
    {
        $this->data['parent_menu'] = 'license';
        $this->data['active_menu'] = 'sales';
        $this->data['title'] = 'Sales';
    }

    public function index(Request $request, GetFilteredSales $action): InertiaResponse
    {
        abort_if(! auth()->user()->can('sales_view'), 403);

        $this->data = array_merge($this->data, $action->execute($request));

        return $this->inertia('Core/Sales/Index', $this->data);
    }
}
