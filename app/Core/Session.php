<?php

namespace Source\Core;

use stdClass;

class Session
{
    protected ?object $session = null;
    public function __construct()
    {
        $this->session = new stdClass();
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    public function set(string $name, object|string $value)
    {
        $_SESSION[$name] = $value;
        $this->session->$name = $_SESSION[$name];
    }

    public function get()
    {
        if(isset($_SESSION)){
            $this->session = (object) $_SESSION;
        }
        return $this->session;
    }
    public function destroy(string $name = "*")
    {
        if($name === "*"){
            session_destroy();
            return true;
        }
        if(!isset($_SESSION[$name])){
            return false;
        }
        unset($_SESSION[$name]);
        return true;
    }
}