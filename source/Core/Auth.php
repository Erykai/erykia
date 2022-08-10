<?php

namespace Source\Core;

use Erykai\Routes\Middleware;
use Source\Model\User;

/**
 * @property Request $request
 */
trait Auth
{
    protected object $user;
    protected object $login;
    protected function auth(): string|bool
    {
        $this->request = new Request();
        $this->user = $this->request->reponse()->data;
        if (!$this->validateEmail()) {
            return false;
        }

        $login = (new User())
            ->find('id, name, email, password', 'email=:email',['email'=>$this->user->email])
            ->fetch();

        if (!isset($login)) {
            $this->setError(t("login invalid"));
            return false;
        }

        if(!password_verify($this->user->password, $login->password)){
            $this->setError(t("password invalid"));
            return false;
        }
        unset($login->password);

        $middleware = new Middleware();

        $this->session->set('login', $login);
        return $middleware->create($login->email);
    }

    protected function destroy()
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