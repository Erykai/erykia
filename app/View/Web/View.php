<?php

namespace Source\View\Web;

class View
{
    public function home(): void
    {
        require dirname(__DIR__, 3) . "/public/".THEME_DEFAULT."/index.php";
    }
}