<?php

namespace Source\Controller\Ia;

use Source\Core\Controller;

class IaController extends Controller
{
    public function read(): void
    {
        require dirname(__DIR__, 3) . "/public/theme/".THEME_ERYKIA."/index.html";
    }
}