<?php

namespace Source\View\Dashboard;

class View extends Resource
{
    private static $instance;

    use ViewTrait\Home;
    use ViewTrait\Register;
    use ViewTrait\AccountProfile;
    use ViewTrait\ForgotPassword;

    protected function __construct()
    {
        parent::__construct();
    }

    public static function getInstance(): View
    {
        if (!self::$instance) {
            self::$instance = new View();
        }

        return self::$instance;
    }
}
