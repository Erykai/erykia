<?php

namespace Source\Core;



class Controller
{
    use Auth;
    protected object $session;
    protected string $error;
    protected object $user;

    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @param string $error
     */
    public function setError(string $error): void
    {
        $this->error = $error;
    }


}