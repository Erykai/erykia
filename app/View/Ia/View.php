<?php

namespace Source\View\Ia;

use Source\Core\Controller;

class View extends Controller
{
    private static $instance;

    protected function __construct()
    {
        parent::__construct();
    }

    public static function getInstance(): View
    {
        if (!self::$instance) {
            self::$instance = new View();
        }

        return self::$instance;
    }

    public function read(): void
    {
        require dirname(__DIR__, 3) . "/public/".THEME_ERYKIA."/index.php";
    }
}
