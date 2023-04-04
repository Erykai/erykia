<?php

namespace Modules\User\View\User;

use Source\Core\Controller;

abstract class Resource extends Controller
{
    public function __construct()
    {
        parent::__construct(TEMPLATE_DASHBOARD);

    }
}