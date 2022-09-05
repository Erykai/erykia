<?php

namespace Source\Controller\System;

use Source\Core\Auth;
use Source\Core\Controller;

class LoginController extends Controller
{
    use Auth;

    public function login($query, string $response): bool
    {
        if($auth = $this->auth()){
            echo $auth;
            return true;
        }
        echo $this->translate->translator($this->getError(), "message")->$response();

        return false;
    }

    public function logout(): bool
    {
        $this->session->destroy();
        return true;
    }
}