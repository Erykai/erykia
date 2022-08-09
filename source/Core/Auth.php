<?php

namespace Source\Core;

use Erykai\Routes\Middleware;
use Source\Model\User;

/**
 * @property Request $request
 */
trait Auth
{
    protected object $login;
    public function login(): bool
    {
        $this->request = new Request();
        if($this->request->error()){
            echo $this->request->error();
            return false;
        }
        $this->user = $this->request->data();
        if (!$this->validateEmail()) {
            echo $this->getError();
            return false;
        }

        $login = (new User())
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

    protected function validateLogin(): bool
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