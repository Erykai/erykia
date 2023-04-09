<?php

namespace Modules\User\View;

use Source\Core\Controller;
use Source\Core\Template;

abstract class Resource extends Controller
{
    public function __construct()
    {
        $directoryPath = dirname(__FILE__);
        $directoryPath = dirname($directoryPath);
        $moduleName = basename($directoryPath);

        $templateIndex = "public/" . TEMPLATE_DASHBOARD;
        $templatePage = 'modules/'.$moduleName.'/Public/' . TEMPLATE_DASHBOARD;
        parent::__construct(TEMPLATE_DASHBOARD, $templateIndex, $templatePage, "php");
    }
}