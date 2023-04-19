<?php

namespace Modules\Example\Controller\ExampleTrait;

use Modules\Example\Model\Example;

trait Upload
{

    public function upload(array $query, string $response): bool
    {
        if ($this->validateLogin() && !$this->permission()) {
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }

        $this->upload = new \Source\Core\Upload();
        if ($this->upload->response()->type === "error") {
            echo $this->translate->translator($this->upload->response(), "message")->$response();
            return false;
        }
        if ($this->upload->save()) {
            foreach ($this->upload->response()->data as $key => $value) {
                echo TEMPLATE_URL . "/" . $value;
            }
        }
        return true;
    }
}