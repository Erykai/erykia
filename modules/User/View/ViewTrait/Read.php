<?php

namespace Modules\User\View\ViewTrait;

use Modules\User\Model\User;
use Source\Core\Cryption;

trait Read
{
    public function read($query)
    {

        if (!$this->loginPermission())
            return false;
        $this->setRequest($query);
        $id = Cryption::getInstance()->decrypt($this->argument->id);
        $this->user = (new User())->find("*","id = :id", ["id" => $id])->fetch();
        $this->user->id = Cryption::getInstance()->encrypt($this->user->id);
        if (empty($this->user->cover)) {
            $this->user->cover = "public/".TEMPLATE_DASHBOARD."/assets/img/illustrations/profiles/profile-1.png";
        }
        $this->template->nav("index", "pages/read", "User");
        $content = $this->template->getIndex();
        echo $this->render($content);
        return true;
    }
}