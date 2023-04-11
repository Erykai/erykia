<?php

namespace Modules\Example\Controller\ExampleTrait;

use Source\Core\Cryption;
use Source\Core\Upload;
use Modules\Example\Model\Example;

trait Store
{
    public function store(array $query, string $response): bool
    {
        $this->setRequest($query);

        if ($this->validateLogin() && !$this->permission()) {
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }

        if ($this->request->response()->type === "error") {
            echo $this->translate->translator($this->request->response(), "message")->$response();
            return false;
        }
        $example = new Example();
        $this->upload = new Upload();
        if (isset($this->data->cover)) {
            if ($this->upload->response()->type === "error") {
                echo $this->translate->translator($this->upload->response(), "message")->$response();
                return false;
            }
            if ($this->upload->save()) {
                foreach ($this->upload->response()->data as $key => $value) {
                    $example->$key = $value;
                    $this->setIssetUpload(true);
                }
            }
        }


        foreach ($this->data as $key => $value) {
            $example->$key = $value;
        }
        if ($this->validateLogin()) {
            $id = (int)$this->session->get()->login->id;
            $example->id_examples = Cryption::getInstance()->decrypt($this->session->get()->login->id);
            $example->dad =
                $id === 1
                    ? Cryption::getInstance()->decrypt($this->session->get()->login->id)
                    : Cryption::getInstance()->decrypt($this->session->get()->login->id) . "," . Cryption::getInstance()->decrypt($this->session->get()->login->dad);
        } else {
            $example->dad = 1;
            $example->id_examples = 1;
            $example->level = 1;
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