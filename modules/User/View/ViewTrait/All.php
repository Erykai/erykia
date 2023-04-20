<?php

namespace Modules\User\View\ViewTrait;


trait All
{
    public function all(): bool
    {
        if (!$this->loginPermission())
            return false;
        $this->template->nav("index", "pages/all","User");
        $content = $this->template->getIndex();
        echo $this->render($content);
        return true;
    }
}