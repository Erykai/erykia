<?php

namespace Source\Core;

class Cryption extends \Erykai\Cryption\Cryption
{
    private static $instance = null;

    private function __construct() {
        parent::__construct();
    }

    public static function getInstance(): Cryption
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
