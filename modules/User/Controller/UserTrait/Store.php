<?php

namespace Modules\User\Controller\UserTrait;

use Source\Core\Cryption;
use Source\Core\Upload;
use Modules\User\Model\User;

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
        $user = new User();
        $this->upload = new Upload();
        if (isset($this->data->cover)) {
            if ($this->upload->response()->type === "error") {
                echo $this->translate->translator($this->upload->response(), "message")->$response();
                return false;
            }
            if ($this->upload->save()) {
                foreach ($this->upload->response()->data as $key => $value) {
                    $user->$key = $value;
                    $this->setIssetUpload(true);
                }
            }
        }


        foreach ($this->data as $key => $value) {
            $user->$key = $value;
        }
        if ($this->validateLogin()) {
            $id = (int)$this->session->get()->login->id;
            $user->id_users = (new Cryption())->decrypt($this->session->get()->login->id);
            $user->dad =
                $id === 1
                    ? (new Cryption())->decrypt($this->session->get()->login->id)
                    : (new Cryption())->decrypt($this->session->get()->login->id) . "," . (new Cryption())->decrypt($this->session->get()->login->dad);
        } else {
            $user->dad = 1;
            $user->id_users = 1;
            $user->level = 1;
        }

        $user->created_at = date("Y-m-d H:i:s");
        $user->updated_at = date("Y-m-d H:i:s");

        if (!$user->save()) {
            if ($this->isIssetUpload()) {
                $this->upload->delete();
            }
            echo $this->translate->translator($user->response(), "message")->$response();
            return false;
        }
        echo $this->translate->translator($user->response(), "message")->$response();
        return true;
    }
}