<?php

namespace Source\Core;

use Erykai\Routes\Middleware;
use Source\Model\User;

/**
 * @property Request $request
 */
trait Auth
{
    protected ?object $data;
    protected ?object $login;
    protected function auth(): string|bool
    {
        $this->setRequest(null);
        if (!$this->validateEmail()) {
            return false;
        }

        $this->login = (new User())
            ->find('id, name, email, password', 'email=:email',['email'=>$this->data->email])
            ->fetch();

        if (!isset($this->login )) {
            $this->setError(401, "error", "login invalid");
            return false;
        }

        if(!password_verify($this->data->password, $this->login ->password)){
            $this->setError(401, "error", "password invalid");
            return false;
        }
        unset($this->login ->password);

        $middleware = new Middleware();

        $this->session->set('login', $this->login );
        return $middleware->create($this->login ->email);
    }

    protected function destroy()
    {
        $this->session->destroy();
        return true;
    }

    protected function validateLogin(): bool
    {
        if (!isset($this->session->get()->login)) {
            $this->setError(401, "error", "protected area login");
            return false;
        }
        $this->login = $this->session->get()->login;
        return true;
    }

    protected function validateEmail(): bool
    {
        if (!empty($this->data->email)) {
            $this->data->email = (filter_var($this->data->email, FILTER_VALIDATE_EMAIL));
            if (!$this->data->email) {
                $this->setError(401, "error", "invalid email format");
                return false;
            }
            return true;
        }
        $this->setError(401, "error", "invalid email format");
        return false;
    }
}