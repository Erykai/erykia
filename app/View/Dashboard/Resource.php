<?php

namespace Source\View\Dashboard;

use Source\Core\Controller;
use Source\Core\Template;

abstract class Resource extends Controller
{
    public function __construct()
    {
        parent::__construct(TEMPLATE_DASHBOARD);
        $this->template = new Template("public/".TEMPLATE_DASHBOARD,"public/".TEMPLATE_DASHBOARD,"php");

    }
}