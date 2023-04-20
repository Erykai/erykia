<?php

namespace Modules\Example\View\ViewTrait;

use stdClass;

trait Store
{
    public function store()
    {
        if (!$this->loginPermission())
            return false;
        $this->example = new stdClass();
        if (empty($this->example->cover)) {
            $this->example->cover = "public/".TEMPLATE_DASHBOARD."/assets/img/illustrations/profiles/profile-1.png";
        }
        $this->template->nav("index", "pages/store","Example");
        $content = $this->template->getIndex();
        echo $this->render($content);
        return true;
    }
}