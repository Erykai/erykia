<?php

namespace Source\View\Dashboard;

use Source\Core\Controller;

abstract class Resource extends Controller
{
    public function __construct()
    {
        $themeIndex = "public/" . TEMPLATE_DASHBOARD;
        $extension = "php";
        parent::__construct(TEMPLATE_DASHBOARD,$themeIndex, $themeIndex, $extension);
    }
}

