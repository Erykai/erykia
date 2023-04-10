<?php

namespace Modules\Example\View\ViewTrait;

trait Store
{
    public function store()
    {
        if (!$this->loginPermission())
            return false;
        $this->template->nav("index", "pages/store","Example");
        $content = $this->template->getIndex();
        echo $this->render($content);
        return true;
    }
}