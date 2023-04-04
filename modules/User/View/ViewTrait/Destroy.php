<?php

namespace Modules\User\View\ViewTrait;

trait Destroy
{
    public function destroy()
    {
        if (!$this->loginPermission())
            return false;
        $this->template->nav("index", "pages/user-destroy");
        $content = $this->template->getIndex();
        echo $this->render($content);
        return true;
    }
}