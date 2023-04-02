<?php

namespace Source\View\Dashboard\ViewTrait;

trait Home
{
    public function home()
    {
        if (!$this->loginPermission())
            return false;
        //create object stdClass $this->teste = "teste" insert in pages/home {{ $teste }} or {{ $teste->teste }}
        $this->template->nav("index", "pages/home");
        $content = $this->template->getIndex();
        echo $this->render($content);
        return true;
    }
}