<?php

namespace Source\Controller\System;

use Source\Core\Controller;
use Source\Core\Response;

class LoginController extends Controller
{
    private static $instance;

    protected function __construct()
    {
        parent::__construct();
    }

    public static function getInstance(): LoginController
    {
        if (!self::$instance) {
            self::$instance = new LoginController();
        }

        return self::$instance;
    }

    public function login(): bool
    {
        if($auth = $this->auth()){
            $this->setResponse(200, "success", $auth, "bearerToken", $this->login);
            echo (new Response())->data($this->getResponse())->json();
            return true;
        }
        echo $this->translate->translator($this->getResponse(), "message")->json();
        return false;
    }

    public function logout(): bool
    {
        $this->session->destroy();
        $this->setResponse(200, "success", "You left successfully, come back soon!", "logout");
        echo $this->translate->translator($this->getResponse(), "message")->json();
        return true;
    }
}
