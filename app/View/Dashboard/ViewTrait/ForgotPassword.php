<?php

namespace Source\View\Dashboard\ViewTrait;

use Source\Core\Template;

trait ForgotPassword
{
    public function forgotPassword()
    {
        $this->template->nav("login","pages/forgot-password");
        $content = $this->template->getIndex();
        echo $this->render($content);
        return true;
    }
}