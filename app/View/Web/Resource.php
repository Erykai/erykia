<?php

namespace Source\View\Web;

use Source\Core\Controller;

abstract class Resource extends Controller
{
    public function __construct()
    {
        parent::__construct(TEMPLATE_DEFAULT, "public/".TEMPLATE_DEFAULT,"public/".TEMPLATE_DEFAULT,"php");
    }
}
