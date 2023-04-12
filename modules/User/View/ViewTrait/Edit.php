<?php

namespace Modules\User\View\ViewTrait;

use Modules\User\Model\User;
use Source\Core\Cryption;
use Source\Core\Service;

trait Edit
{
    public function edit($query)
    {

        if (!$this->loginPermission())
            return false;
        $this->setRequest($query);
        $endpoint = TEMPLATE_URL . "/users/" . $this->argument->id;
        $this->user = Service::getInstance()->get($endpoint);
        if (empty($this->user->cover)) {
            $this->user->cover = "public/".TEMPLATE_DASHBOARD."/assets/img/illustrations/profiles/profile-1.png";
        }
        $this->template->nav("index", "pages/edit", "User");
        $content = $this->template->getIndex();
        echo $this->render($content);
        return true;
    }
}