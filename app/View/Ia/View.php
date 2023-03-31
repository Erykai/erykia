<?php

namespace Source\View\Ia;

use Source\Core\Controller;

class View extends Controller
{
    public function read(): void
    {
        require dirname(__DIR__, 3) . "/public/".THEME_ERYKIA."/index.php";
    }
}