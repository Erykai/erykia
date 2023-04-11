<?php

namespace Modules\User\Controller;

use Modules\User\Controller\UserTrait\Destroy;
use Modules\User\Controller\UserTrait\Edit;
use Modules\User\Controller\UserTrait\Read;
use Modules\User\Controller\UserTrait\Store;
use Source\Controller\System\Resource;

class UserController extends Resource
{
    use Store;
    use Edit;
    use Read;
    use Destroy;
    private static $instance;

    protected function __construct()
    {
        parent::__construct();
    }

    public static function getInstance(): UserController
    {
        if (!self::$instance) {
            self::$instance = new UserController();
        }

        return self::$instance;
    }
}
