<?php

namespace Source\Controller\Web;

use Source\Core\Auth;
use Source\Core\Controller;
use Source\Core\Upload;
use Source\Model\User;

class UserController extends Controller
{
    use Auth;

    public function store($query, string $response)
    {
        $this->setRequest($query);
        if ($this->request->response()->type === "error") {
            if ($response === 'json') {
                echo $this->response->data($this->request->response())->lang()->$response();
            } else {
                var_dump($this->response->data($this->request->response())->lang()->$response());
            }
            return false;
        }

        $this->upload = new Upload();
        if ($this->upload->response()->type === "error") {
            if ($response === 'json') {
                echo $this->response->data($this->upload->response())->lang()->$response();
            } else {
                var_dump($this->response->data($this->upload->response())->lang()->$response());
            }
            return false;
        }

        $user = new User();
        $existUpload = false;
        if ($this->upload->save()) {
            foreach ($this->upload->response()->data as $key => $value) {
                $user->$key = $value;
                $existUpload = true;
            }
        }
        foreach ($this->data as $key => $value) {
            $user->$key = $value;
        }

        if (!$user->save()) {
            if ($existUpload) {
                $this->upload->delete();
            }
            if ($response === 'json') {
                echo $this->response->data($user->response())->lang()->$response();
                return false;
            }
            var_dump($this->response->data($user->response())->lang()->$response());
            return false;
        }
        if ($response === 'json') {
            echo $this->response->data($user->response())->lang()->$response();
            return true;
        }
        var_dump($this->response->data($user->response())->lang()->$response());
        return true;
    }

    public function read($query, string $response)
    {
        $this->setRequest($query);
        if (isset($this->query->search)) {
            $this->setSearch($this->query->search);
        }
        $users = new User();
        $all = $users->find("id", $this->getFind(), $this->getParams())->count();
        $this->setPaginator($all);
        $this->setOrder();
        $user = $users
            ->find("*",$this->getFind(), $this->getParams())
            ->order($this->getOrder())
            ->limit($this->query->per_page)
            ->offset($this->getOffset())
            ->fetch(true);
        if (!$user) {
            echo $this->response->data($users->response())->lang()->$response();
            return false;
        }
        $this->paginator->data = $user;
        echo $this->response->data($this->getPaginator())->$response();
        return true;
    }

    public function edit($query, string $response)
    {

        if (!$this->validateLogin()) {
            echo $this->response->data($this->getError())->lang()->$response();
            return false;
        }
        $this->setRequest($query);
        var_dump($this);

        $login = $this->session->get()->login;
        $users = (new User());
        $user = $users->find('*', 'email=:email', ['email' => $login->email])->fetch();
        if(!$user){
            $this->setError(401, "error", "user does not exist");
            echo $this->response->data($this->getError())->lang()->json();
            return false;
        }
        foreach ($this->data as $key => $value) {
            if(
                ($key === 'email') &&
                (new User())->find('id', 'email=:email', ['email' => $this->data->$key])->fetch() &&
                $this->data->$key !== $login->email
            ) {
                $this->setError(401, "error", "this email already exists");
                echo $this->response->data($this->getError())->lang()->json();
                return false;
            }
            if ($key === 'password') {
                $this->data->$key = password_hash($value, PASSWORD_BCRYPT, ['cost' => 12]);
            }
            $user->$key = $this->data->$key;
        }
        if(!$users->save()){
            $this->setError(401, "error", "error saving");
            echo $this->response->data($this->getError())->lang()->json();
            return false;
        }
      $this->session->destroy('login');
      $this->session->set('login', $user);
      return true;
    }

    public function destroy(array $data)
    {/*
        if(!isset($data[0])){
            $this->setError(t("you don't have this permission"));
            echo $this->getError();
            return false;
        }

        if (!$this->validateLogin()) {
            echo $this->getError();
            return false;
        }

        $login = $this->session->get()->login;
        $users = new \Source\Model\User();
        $user = $users->find('*', 'email=:email', ['email' => $login->email])->fetch();

        if(!$user){
            $this->setError(t("you don't have this permission"));
            echo $this->getError();
            return false;
        }
        if($user->id !== $data[0]['id']){
            $this->setError(t("you don't have this permission"));
            echo $this->getError();
            return false;
        }

        $users->delete($user->id);
   */
    }
}