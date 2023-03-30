<?php

namespace Source\Controller\System\UserTrait;

use Source\Core\Upload;
use Source\Model\User;

trait Edit
{
    public function edit(array $query, string $response): bool
    {
        $this->setRequest($query);

        if (!$this->permission()) {
            echo $this->translate->translator($this->getResponse(), "message")->$response();
        }

        $login = $this->session->get()->login;
        $users = (new User());
        $dad = $users->find('users.dad',
            'users.id=:id',
            ['id' => $this->argument->id])
            ->fetchReference(getColumns: $this->getColumns());
        $user = null;

        if (!$dad) {
            $this->setResponse(401, "error", "this user does not exist", "edit");
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }


        if ($login->id !== $this->argument->id) {
            $dads = explode(",", $dad->dad);
            foreach ($dads as $dad) {
                if ($dad === $login->id) {
                    $user = $users->find('id,name,email,cover',
                        'users.id=:id',
                        ['id' => $this->argument->id])
                        ->fetchReference(getColumns: $this->getColumns());
                }
            }
        } else {
            $user = $users->find('id,name,email,cover',
                'users.id=:id',
                ['id' => $this->argument->id])
                ->fetchReference(getColumns: $this->getColumns());
        }


        if (!$user) {
            $this->setResponse(401, "error", "you do not have permission to make this edit", "edit");
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }

        foreach ($this->data as $key => $value) {
            if (
                ($key === 'email')
                &&
                (new User())->find('id', 'email=:email', ['email' => $this->data->$key])->fetch()
                &&
                $this->data->$key !== $user->email
            ) {
                $this->setResponse(401, "error", "this email already exists", "edit");
                echo $this->translate->translator($this->getResponse(), "message")->json();
                return false;
            }

            $user->$key = $this->data->$key;
        }
        if (isset($user->updated_at)) {
            $user->updated_at = date("Y-m-d H:i:s");
        }

        $this->upload = new Upload();
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

        if (!$users->save()) {
            if ($this->isIssetUpload()) {
                $this->upload->delete();
            }
            $this->setResponse(401, "error", "error saving", "edit");
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }
        if ($login->id === $this->argument->id) {
            $this->session->destroy('login');
            $this->session->set('login', $user);
        }
        echo $this->translate->translator($users->response(), "message")->json();
        return true;
    }
}