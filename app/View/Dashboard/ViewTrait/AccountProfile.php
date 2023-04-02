<?php

namespace Source\View\Dashboard\ViewTrait;

trait AccountProfile
{
    public function accountProfile()
    {
        if(!$this->loginPermission())
            return false;
        $this->year = date("Y");
        $this->template->nav("index","pages/account-profile");
        $content = $this->template->getIndex();
        echo $this->render($content);
        return true;
    }
}