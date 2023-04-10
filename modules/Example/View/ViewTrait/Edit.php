<?php

namespace Modules\Example\View\ViewTrait;

use Modules\Example\Model\Example;
use Source\Core\Cryption;

trait Edit
{
    public function edit($query)
    {

        if (!$this->loginPermission())
            return false;
        $this->setRequest($query);
        $id = (new Cryption())->decrypt($this->argument->id);
        $this->example = (new Example())->find("*","id = :id", ["id" => $id])->fetch();
        $this->example->id = (new Cryption())->encrypt($this->example->id);
        if (empty($this->example->cover)) {
            $this->example->cover = "public/".TEMPLATE_DASHBOARD."/assets/img/illustrations/profiles/profile-1.png";
        }
        $this->template->nav("index", "pages/edit", "Example");
        $content = $this->template->getIndex();
        echo $this->render($content);
        return true;
    }
}