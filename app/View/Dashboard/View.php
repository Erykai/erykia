<?php

namespace Source\View\Dashboard;

use Source\Core\Controller;
use Source\Core\Template;

class View extends Controller
{
    public function home()
    {
        $t= new Template(TEMPLATE_DASHBOARD, "php");

        if (!$this->permission()) {
            $t->nav("login","pages/forgot-password");
            echo $t->getIndex();
            return false;
        }
        $t->nav("index","pages/home");
        echo $t->getIndex();
        return true;
    }
}