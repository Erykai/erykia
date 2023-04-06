<?php

namespace Modules\User\View\ViewTrait;

trait Trash
{
    public function trash()
    {
        if (!$this->loginPermission())
            return false;
        $this->template->nav("index", "pages/trash","User");
        $content = $this->template->getIndex();
        echo $this->render($content);
        return true;
    }
}