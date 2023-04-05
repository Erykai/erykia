<?php

namespace Modules\User\Controller\UserTrait;

use Source\Core\Cryption;
use Modules\User\Model\User;

trait Edit
{
    public function edit($query, string $response): bool
    {
        $this->setRequest($query);
        if (!$this->permission()) {
            echo $this->translate->translator($this->getResponse(), "message")->$response();
        }
        $id = (new Cryption())->decrypt($this->argument->id);

        $login = $this->session->get()->login;

        $users = (new User());
        $dad = $users->find('users.dad',
            'users.id=:id',
            ['id' => $id])
            ->fetch();
        $user = null;

        if (!$dad) {
            $this->setResponse(401, "error", "this user does not exist", "edit");
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }

        if ($login->id !== $this->argument->id) {
            $dads = explode(",", $dad->dad);
            foreach ($dads as $dad) {
                if ($dad === (new Cryption())->decrypt($login->id)) {
                    $user = $users->find('*',
                        'users.id=:id',
                        ['id' => $id])
                        ->fetch();
                }
            }
        } else {
            $user = $users->find('*',
                'users.id=:id',
                ['id' => $id])
                ->fetch();
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

        if(empty($this->data->password)){
            unset($user->password);
        }

        $this->setUpload($user);

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