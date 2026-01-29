<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function __construct()
    {
        $this->isInstalled();
    }

    public function isInstalled()
    {
        if (! file_exists(storage_path('installed'))) {
            return redirect()->to(url('/install'))->send();
        }
    }
}
