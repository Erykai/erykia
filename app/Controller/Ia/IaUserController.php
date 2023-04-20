<?php

namespace Source\Controller\Ia;

use Source\Controller\Ia\IaUserTrait\Store;

class IaUserController extends Resource
{
    private static $instance;

    public function __construct()
    {
        parent::__construct();
    }

    public static function getInstance(): IaUserController
    {
        if (!self::$instance) {
            self::$instance = new IaUserController();
        }

        return self::$instance;
    }

    use Store;
}
