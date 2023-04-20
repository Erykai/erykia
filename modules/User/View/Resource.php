<?php

namespace Modules\User\View;

use Source\Core\Controller;

abstract class Resource extends Controller
{
    private static array $instances = [];

    public function __construct()
    {
        $directoryPath = dirname(__FILE__);
        $directoryPath = dirname($directoryPath);
        $moduleName = basename($directoryPath);

        $templateIndex = "public/" . TEMPLATE_DASHBOARD;
        $templatePage = 'modules/'.$moduleName.'/Public/' . TEMPLATE_DASHBOARD;
        parent::__construct(TEMPLATE_DASHBOARD, $templateIndex, $templatePage, "php");
    }

    public static function getInstance()
    {
        $class = get_called_class();
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new $class();
        }

        return self::$instances[$class];
    }
}
