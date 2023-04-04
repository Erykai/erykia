<?php

namespace Modules\User\View;

use Source\Core\Controller;

abstract class Resource extends Controller
{
    public function __construct()
    {
        $directoryPath = dirname(__FILE__);
        $directoryPath = dirname($directoryPath);
        $moduleName = basename($directoryPath);

        $templateIndex = "public/" . TEMPLATE_DASHBOARD;
        $templatePage = 'modules/'.$moduleName.'/Public/' . TEMPLATE_DASHBOARD;
        parent::__construct($templateIndex, $templatePage);
    }
}