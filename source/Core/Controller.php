<?php

namespace Source\Core;



class Controller
{
    protected Request $request;
    protected Upload $upload;
    protected object $session;
    protected ?string $error = null;

    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @return string|null
     */
    protected function getError(): ?string
    {
        return $this->error;
    }

    /**
     * @param string $error
     */
    protected function setError(string $error): void
    {
        $this->error = $error;
    }


}