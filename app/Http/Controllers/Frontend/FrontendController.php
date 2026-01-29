<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Setting;

class FrontendController extends Controller
{
    protected array $data = [];

    public function __construct()
    {
        $this->data['appName'] = Setting::get('app_name', 'Laraku');
        $this->data['appLogo'] = Setting::get('app_logo');
        $this->data['appDescription'] = Setting::get('app_description', 'Modern Laravel Admin Panel');
    }

    protected function inertia(string $component, array $props = [])
    {
        return inertia($component, array_merge($this->data, $props));
    }
}
