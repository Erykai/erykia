<?php

namespace Source\View\Dashboard\ViewTrait;

trait UserManagementList
{
    public function userManagementList()
    {
        if (!$this->loginPermission())
            return false;
        $this->year = date("Y");
        $this->template->nav("index", "pages/user-management-list");
        $content = $this->template->getIndex();
        echo $this->render($content);
        return true;
    }
}