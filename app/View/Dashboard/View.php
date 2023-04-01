<?php

namespace Source\View\Dashboard;

use Source\Core\Controller;
use Source\Core\Template;

class View extends Controller
{
    private $template;
    public function __construct()
    {
        parent::__construct();
        $this->template = new Template(TEMPLATE_DASHBOARD, "php");

    }

    public function home()
    {

        if (!$this->permission()) {
            $this->template->nav("login","pages/login");
            echo $this->template->getIndex();
            return false;
        }
        $this->template->nav("index","pages/home");
        echo $this->template->getIndex();
        return true;
    }
    public function register()
    {
        if (!$this->permission()) {
            $this->template->nav("login","pages/register");
            echo $this->template->getIndex();
            return false;
        }
        $this->template->nav("index","pages/home");
        echo $this->template->getIndex();
        return true;
    }

    public function forgot()
    {
        if (!$this->permission()) {
            $this->template->nav("login","pages/forgot-password");
            echo $this->template->getIndex();
            return false;
        }
        $this->template->nav("index","pages/home");
        echo $this->template->getIndex();
        return true;
    }
}