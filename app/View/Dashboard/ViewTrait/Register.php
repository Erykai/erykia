<?php

namespace Source\View\Dashboard\ViewTrait;

use Source\Core\Template;

trait Register
{
    public function register()
    {
        $this->template->nav("login","pages/register");
        $content = $this->template->getIndex();
        echo $this->render($content);
        return true;
    }
}