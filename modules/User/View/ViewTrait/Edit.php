<?php

namespace Modules\User\View\ViewTrait;

use Modules\User\Model\User;
use Source\Core\Cryption;

trait Edit
{
    public function edit($query)
    {

        if (!$this->loginPermission())
            return false;
        $this->setRequest($query);
        $id = (new Cryption())->decrypt($this->argument->id);
        $this->user = (new User())->find("*","id = :id", ["id" => $id])->fetch();
        $this->user->id = (new Cryption())->encrypt($this->user->id);
        $this->template->nav("index", "pages/edit", "User");
        $content = $this->template->getIndex();
        echo $this->render($content);
        return true;
    }
}