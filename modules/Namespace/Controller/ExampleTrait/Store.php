<?php

namespace Modules\Namespace\Controller\ExampleTrait;

use Modules\Namespace\Model\Example;

trait Store
{
    public function store($query, string $response): bool
    {
        $this->setRequest($query);

        if (!$this->permission()) {
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }

        if ($this->request->response()->type === "error") {
            echo $this->translate->translator($this->request->response(), "message")->$response();
            return false;
        }

        $example = new Example();
        $this->setUpload($example);
        foreach ($this->data as $key => $value) {
            $example->$key = $value;
        }
        if ($this->validateLogin()) {
            $id = (int)$this->session->get()->login->id;
            $example->id_users = $this->session->get()->login->id;
            $example->dad =
                $id === 1
                    ? $this->session->get()->login->id
                    : $this->session->get()->login->id . "," . $this->session->get()->login->dad;
        } else {
            $example->dad = 1;
            $example->id_users = 1;
        }

        $example->created_at = date("Y-m-d H:i:s");
        $example->updated_at = date("Y-m-d H:i:s");

        if (!$example->save()) {
            if ($this->isIssetUpload()) {
                $this->upload->delete();
            }
            echo $this->translate->translator($example->response(), "message")->$response();
            return false;
        }
        echo $this->translate->translator($example->response(), "message")->$response();
        return true;
    }
}