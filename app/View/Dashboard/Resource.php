<?php

namespace Source\View\Dashboard;

use Source\Core\Controller;
use Source\Core\Template;

abstract class Resource extends Controller
{
    public string $menu;

    public function __construct()
    {
        parent::__construct(TEMPLATE_DASHBOARD);
        $module_directories = glob(dirname(__DIR__, 3) . '/modules/*', GLOB_ONLYDIR);
        $this->menu = "";
        foreach ($module_directories as $directory) {
            $menu_file = $directory . '/Public/'.TEMPLATE_DASHBOARD.'/menu.php';
            if (file_exists($menu_file)) {
                $this->menu .= file_get_contents($menu_file);
            }
        }
        $this->template = new Template("public/".TEMPLATE_DASHBOARD,"public/".TEMPLATE_DASHBOARD,"php", $this->menu);

    }
}

