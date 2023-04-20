<?php

namespace Modules\User\View\ViewTrait;

use stdClass;

trait Store
{
    public function store()
    {
        if (!$this->loginPermission())
            return false;
        $this->user = new stdClass();
        if (empty($this->user->cover)) {
            $this->user->cover = "public/".TEMPLATE_DASHBOARD."/assets/img/illustrations/profiles/profile-1.png";
        }
        $this->template->nav("index", "pages/store","User");
        $content = $this->template->getIndex();
        echo $this->render($content);
        return true;
    }
}