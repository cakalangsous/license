<?php

namespace App\View\Components;

use App\Services\ThemeService;
use Illuminate\View\Component;
use Illuminate\View\View;

class ThemeStyles extends Component
{
    /**
     * The CSS variables string
     */
    public string $cssVariables;

    /**
     * Create a new component instance
     */
    public function __construct()
    {
        $this->cssVariables = ThemeService::getCssVariables();
    }

    /**
     * Get the view / contents that represent the component
     */
    public function render(): View
    {
        return view('components.theme-styles');
    }
}
