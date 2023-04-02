<?php

namespace Source\View\Dashboard\ViewTrait;

trait Register
{
    public function register()
    {
        if(!$this->loginPermission())
            return false;
        $this->template->nav("index","pages/home");
        $content = $this->template->getIndex();
        echo $this->render($content);
        return true;
    }
}