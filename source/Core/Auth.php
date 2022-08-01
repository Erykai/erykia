<?php

namespace Source\Core;

use Erykai\Routes\Middleware;

trait Auth
{
    protected object $login;
    public function login(): bool
    {
        $this->user = $this->getData();
        if (count(get_object_vars($this->user)) === 0) {
            echo $this->getError();
            return false;
        }
        if (!$this->validateEmail()) {
            echo $this->getError();
            return false;
        }

        $login = (new \Source\Model\User())
            ->find('id, name, email, password', 'email=:email',['email'=>$this->user->email])
            ->fetch();

        if (!isset($login)) {
            $this->setError(t("login invalid"));
            echo $this->getError();
            return false;
        }

        if(!password_verify($this->user->password, $login->password)){
            $this->setError(t("password invalid"));
            echo $this->getError();
            return false;
        }
        unset($login->password);

        $middleware = new Middleware();

        $this->session->set('login', $login);
        echo $middleware->create($login->email);
        return true;
    }

    public function logout()
    {
        $this->session->destroy();
        return true;
    }

    protected function validateLogin()
    {
        if (!isset($this->session->get()->login)) {
            $this->setError(t("protected area login"));
            return false;
        }
        $this->login = $this->session->get()->login;
        return true;
    }

    protected function validateEmail(): bool
    {
        if (!empty($this->user->email)) {
            $this->user->email = (filter_var($this->user->email, FILTER_VALIDATE_EMAIL));
            if (!$this->user->email) {
                $this->setError(t("invalid email format"));
                return false;
            }
            return true;
        }
        $this->setError(t("invalid email format"));
        return false;
    }
}