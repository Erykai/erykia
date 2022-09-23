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
            $json['bearerToken'] = $auth;
            echo $this->response->data((object)$json)->json();
            return true;
        }
        echo $this->translate->translator($this->getError(), "message")->$response();

        return false;
    }

    public function logout(): bool
    {
        $this->session->destroy();
        $json['logout'] = $this->translate
            ->translatorString("You left successfully, come back soon!","message")
            ->object()->text;
        echo $this->response->data((object)$json)->json();
        return true;
    }
}