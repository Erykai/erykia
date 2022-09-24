<?php

namespace Source\Controller\System;

use Source\Core\Auth;
use Source\Core\Controller;
use Source\Core\Response;
use Source\Core\Upload;
use Source\Model\User;

class UserController extends Controller
{
    use Auth;

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

        $this->upload = new Upload();
        if ($this->upload->response()->type === "error") {
            echo $this->translate->translator($this->upload->response(), "message")->$response();
            return false;
        }

        $user = new User();
        if ($this->upload->save()) {
            foreach ($this->upload->response()->data as $key => $value) {
                $user->$key = $value;
                $this->setIssetUpload(true);
            }
        }
        foreach ($this->data as $key => $value) {
            $user->$key = $value;
        }
        if ($this->validateLogin()) {
            $id = (int)$this->session->get()->login->id;
            $user->id_users = $this->session->get()->login->id;
            $user->dad =
                $id === 1
                    ? $this->session->get()->login->id
                    : $this->session->get()->login->id . "," . $this->session->get()->login->dad;
        } else {
            $user->dad = 1;
            $user->id_users = 1;
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

    public function read($query, string $response): bool
    {
        $this->setRequest($query);
        if (isset($this->query->search)) {
            $this->setSearch($this->query->search);
        }
        $users = new User();
        $arguments = (array)$this->argument;

        if ($arguments) {
            $find = null;
            foreach ($arguments as $key => $argument) {
                $find .= "$key = :$key AND ";
            }
            $find = substr(trim($find), 0, -4);
            $user = $users->find(condition: $find, params: $arguments)->fetchReference(getColumns: $this->getColumns());
            if (!$user) {
                echo $this->translate->translator($users->response(), "message")->$response();
                return false;
            }
            echo (new Response())->data($user)->$response();
            return true;
        }

        $all = $users->find("users.id", $this->getFind(), $this->getParams())->fetchReference(count: true);
        $this->setPaginator($all);
        $this->setOrder();
        $this->setColumns();
        $user = $users
            ->find("*", $this->getFind(), $this->getParams())
            ->order($this->getOrder())
            ->limit($this->query->per_page)
            ->offset($this->getOffset())
            ->fetchReference(true, $this->getColumns());
        if (!$user) {
            echo $this->translate->translator($users->response(), "message")->$response();
            return false;
        }
        $this->paginator->data = $user;
        echo (new Response())->data($this->getPaginator())->$response();
        return true;
    }

    public function edit($query, string $response): bool
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

        if(!$dad){
            $this->setResponse(401, "error", "this user does not exist", "edit");
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }


        if ($login->id !== $this->argument->id) {
            $dads = explode(",", $dad->dad);
            foreach ($dads as $dad) {
                if ($dad === $login->id) {
                    $user = $users->find('*',
                        'users.id=:id',
                        ['id' => $this->argument->id])
                        ->fetchReference(getColumns: $this->getColumns());
                }
            }
        } else {
            $user = $users->find('*',
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
            if ($key === 'password') {
                $this->data->$key = password_hash($value, PASSWORD_BCRYPT, ['cost' => 12]);
            }
            $user->$key = $this->data->$key;
        }
        if (isset($user->updated_at)) {
            $user->updated_at = date("Y-m-d H:i:s");
        }
        if (!$users->save()) {
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

    public function destroy($query, string $response): bool
    {
        $this->setRequest($query);
        if (!$this->permission()) {
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }
        $login = $this->session->get()->login;
        if ($login->id === $this->argument->id) {
            $this->setResponse(401, "error", "you cannot delete your registration", "delete");
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }

        $users = (new User());
        $dad = $users->find('users.dad',
            'users.id=:id',
            ['id' => $this->argument->id])
            ->fetchReference(getColumns: $this->getColumns());
        $user = null;

        if (!$dad) {
            $this->setResponse(401, "error", "this user does not exist", "delete");
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }

        $dads = explode(",", $dad->dad);
        foreach ($dads as $dad) {
            if ($dad === $login->id) {
                $user = $users->find('*',
                    'users.id=:id',
                    ['id' => $this->argument->id])
                    ->fetchReference(getColumns: $this->getColumns());
            }
        }

        if (!$user) {
            $this->setResponse(401, "error", "you do not have permission to make this delete", "delete");
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }

        $users->delete($this->argument->id);
        $this->setResponse(200, "success", "registration successfully deleted", "delete");
        echo $this->translate->translator($this->getResponse(), "message")->json();
        return true;
    }
}