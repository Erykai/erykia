<?php

namespace Modules\User\View\ViewTrait;

trait Store
{
    public function store()
    {
        if (!$this->loginPermission())
            return false;
        $this->template->nav("index", "pages/store","User");
        $content = $this->template->getIndex();
        echo $this->render($content);
        return true;
    }
}