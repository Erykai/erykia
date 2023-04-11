<?php

namespace Modules\Example\View\ViewTrait;

use Modules\Example\Model\Example;
use Source\Core\Cryption;

trait Read
{
    public function read($query)
    {

        if (!$this->loginPermission())
            return false;
        $this->setRequest($query);
        $id = Cryption::getInstance()->decrypt($this->argument->id);
        $this->example = Cryption::getInstance()->find("*","id = :id", ["id" => $id])->fetch();
        $this->example->id = Cryption::getInstance()->encrypt($this->example->id);
        if (empty($this->example->cover)) {
            $this->example->cover = "public/".TEMPLATE_DASHBOARD."/assets/img/illustrations/profiles/profile-1.png";
        }
        $this->template->nav("index", "pages/read", "Example");
        $content = $this->template->getIndex();
        echo $this->render($content);
        return true;
    }
}