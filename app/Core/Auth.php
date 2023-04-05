<?php

namespace Source\Core;

use Erykai\Routes\Middleware;
use Modules\User\Model\User;

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
            ->find('id, id_users, dad, name, email, password, cover, level', 'email=:email',['email'=>$this->data->email])
            ->fetch();

        if (!isset($this->login )) {
            $this->setResponse(401, "error", "login invalid", "login");
            return false;
        }

        if(!isset($this->data->password)){
            $this->setResponse(401, "error", "password mandatory", "login");
            return false;
        }

        if(!password_verify($this->data->password, $this->login->password)){
            $this->setResponse(401, "error", "password invalid", "login");
            return false;
        }
        unset($this->login->password);

        $middleware = new Middleware();
        $this->session->set('login', $this->login );
        return $middleware->create($this->login->email);
    }
    protected function validateLogin(): bool
    {
        if (!isset($this->session->get()->login)) {
            $this->setResponse(401, "error", "protected area login", "login");
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
                $this->setResponse(401, "error", "invalid email format", "login");
                return false;
            }
            return true;
        }
        $this->setResponse(401, "error", "invalid email format", "login");
        return false;
    }
}