<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class CoreController extends Controller
{
    public $data = [
        'parent_menu' => '',
        'active_menu' => '',
        'title' => 'Laraku',
    ];

    public function __construct()
    {
        parent::isInstalled();
    }

    public function inertia($component = '', $props = []): InertiaResponse
    {
        $props = array_merge($this->data, $props);

        return Inertia::render($component, $props);
    }
}
