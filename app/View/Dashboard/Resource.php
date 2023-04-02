<?php

namespace Source\View\Dashboard;

use Source\Core\Controller;
use Source\Core\Template;

abstract class Resource extends Controller
{
    protected $template;
    public function __construct()
    {
        parent::__construct();
        $this->template = new Template(TEMPLATE_DASHBOARD, "php");

    }
    protected function loginPermission(){
        if (!$this->permission()) {
            $this->template->nav("login","pages/login");
            $content = $this->template->getIndex();
            echo $this->render($content);
            return false;
        }
        if (empty($this->login->cover)) {
            $this->login->cover = "public/".TEMPLATE_DASHBOARD."/assets/img/illustrations/profiles/profile-1.png";
        }
        return true;
    }
}