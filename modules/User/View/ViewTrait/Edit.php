<?php

namespace Modules\User\View\ViewTrait;

trait Edit
{
    public function edit()
    {
        if (!$this->loginPermission())
            return false;
        $this->template->nav("index", "pages/edit", "User");
        $content = $this->template->getIndex();
        echo $this->render($content);
        return true;
    }
}