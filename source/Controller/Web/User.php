<?php

namespace Source\Controller\Web;

use Erykai\Routes\Middleware;
use Source\Core\Controller;
use Source\Core\Session;

class User extends Controller
{
    public function store($query = null): bool
    {
        $this->user = $this->getData();
        if (count(get_object_vars($this->user)) === 0) {
            echo $this->getError();
            return false;
        }
        $this->request($query);
        if (!$this->validateEmail()) {
            echo $this->getError();
            return false;
        }

        if ((new \Source\Model\User())->find('id', 'email=:email', ['email' => $this->user->email])->fetch()) {
            $this->setError(t("this email already exists"));
            echo $this->getError();
            return false;
        }

        $user = new \Source\Model\User();
        foreach ($this->user as $key => $value) {
            if ($key === 'password') {
                $value = password_hash($value, PASSWORD_BCRYPT, ['cost' => 12]);
            }
            $user->$key = $value;
        }
        if (!$user->save()) {
            echo $user->error();
            return false;
        }
        echo t("registration successful");
        return true;
    }

    public function read()
    {
        $users = new \Source\Model\User();
        $user = $users->find()->fetch();
        var_dump($user);
    }

    public function edit($query = null)
    {
        if (!$this->validateLogin()) {
            echo $this->getError();
            return false;
        }
        $this->user = $this->getData();
        $login = $this->session->get()->login;
        $users = (new \Source\Model\User());
        $user = $users->find('*', 'email=:email', ['email' => $login->email])->fetch();
        if(!$user){
            $this->setError(t("user does not exist"));
            echo $this->getError();
            return false;
        }
        foreach ($this->user as $key => $value) {
            if(
                ($key === 'email') &&
                (new \Source\Model\User())->find('id', 'email=:email', ['email' => $this->user->$key])->fetch() &&
                $this->user->$key !== $login->email
            ) {
                $this->setError(t("this email already exists"));
                echo $this->getError();
                return false;
            }
            if ($key === 'password') {
                $this->user->$key = password_hash($value, PASSWORD_BCRYPT, ['cost' => 12]);
            }
            $user->$key = $this->user->$key;
        }
        if(!$users->save()){
            $this->setError(t("error saving"));
            echo $this->getError();
            return false;
        }
      $this->session->destroy('login');
      $this->session->set('login', $user);
    }

    public function destroy(array $data)
    {
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
    }
}