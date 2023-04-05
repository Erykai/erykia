<?php

namespace Source\View\Dashboard\ViewTrait;

use Source\Core\Template;

trait AccountProfile
{
    public function accountProfile()
    {
        if(!$this->loginPermission())
            return false;
        $this->template->nav("index","pages/account-profile");
        $content = $this->template->getIndex();
        echo $this->render($content);
        return true;
    }
}