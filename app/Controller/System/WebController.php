<?php

namespace Source\Controller\System;

use Source\Core\Controller;

class WebController extends Controller
{
    public function home(): void
    {
        require dirname(__DIR__, 3) . "/public/".THEME_DEFAULT."/index.php";
    }
}