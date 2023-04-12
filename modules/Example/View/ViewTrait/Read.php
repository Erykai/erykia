<?php

namespace Modules\Example\View\ViewTrait;

use Modules\Example\Model\Example;
use Source\Core\Cryption;
use Source\Core\Service;

trait Read
{
    public function read($query)
    {

        if (!$this->loginPermission())
            return false;
        $this->setRequest($query);
        $endpoint = TEMPLATE_URL . "/examples/" . $this->argument->id;
        $this->example = Service::getInstance()->get($endpoint);
        if (empty($this->example->cover)) {
            $this->example->cover = "public/".TEMPLATE_DASHBOARD."/assets/img/illustrations/profiles/profile-1.png";
        }
        $this->template->nav("index", "pages/read", "Example");
        $content = $this->template->getIndex();
        echo $this->render($content);
        return true;
    }
}