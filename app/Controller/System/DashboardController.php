<?php

namespace Source\Controller\System;

use Source\Core\Controller;

class DashboardController extends Controller
{
    public function home(): void
    {
        require dirname(__DIR__, 3) . "/public/theme/".THEME_DASHBOARD."/index.html";
    }
}