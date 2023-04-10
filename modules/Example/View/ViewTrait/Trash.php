<?php

namespace Modules\Example\View\ViewTrait;

trait Trash
{
    public function trash()
    {
        if (!$this->loginPermission())
            return false;
        $this->template->nav("index", "pages/trash","Example");
        $content = $this->template->getIndex();
        echo $this->render($content);
        return true;
    }
}