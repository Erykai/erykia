<?php

namespace Source\View\Dashboard\ViewTrait;

trait ForgotPassword
{
    public function forgotPassword()
    {
        if(!$this->loginPermission())
            return false;
        $this->template->nav("index","pages/home");
        $content = $this->template->getIndex();
        echo $this->render($content);
        return true;
    }
}