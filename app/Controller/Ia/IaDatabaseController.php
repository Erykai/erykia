<?php

namespace Source\Controller\Ia;

use Source\Controller\Ia\IaDatabaseTrait\Store;

class IaDatabaseController extends Resource
{
    private static $instance;

    protected function __construct()
    {
        parent::__construct();
    }

    public static function getInstance(): IaDatabaseController
    {
        if (!self::$instance) {
            self::$instance = new IaDatabaseController();
        }

        return self::$instance;
    }

    use Store;
}
