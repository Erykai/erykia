<?php

namespace Modules\Example\View\ViewTrait;


trait All
{
    public function all(): bool
    {
        if (!$this->loginPermission())
            return false;
        $this->template->nav("index", "pages/all","Example");
        $content = $this->template->getIndex();
        echo $this->render($content);
        return true;
    }
}