<?php

namespace Source\Controller\Web;

use Source\Core\Auth;
use Source\Core\Controller;

class LoginController extends Controller
{
    use Auth;

    public function login(): bool
    {
        if($auth = $this->auth()){
            echo $auth;
            return true;
        }
        echo $this->getError();
        return false;
    }

    public function logout(): void
    {
        $this->destroy();
    }
}