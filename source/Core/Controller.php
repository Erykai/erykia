<?php

namespace Source\Core;


class Controller
{
    use Auth;
    protected object $session;
    public function __construct()
    {
        $this->session = new Session();
    }

}