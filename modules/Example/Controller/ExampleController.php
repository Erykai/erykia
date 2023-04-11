<?php

namespace Modules\Example\Controller;

use Modules\Example\Controller\ExampleTrait\Destroy;
use Modules\Example\Controller\ExampleTrait\Edit;
use Modules\Example\Controller\ExampleTrait\Read;
use Modules\Example\Controller\ExampleTrait\Store;
use Source\Controller\System\Resource;

class ExampleController extends Resource
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

    public static function getInstance(): ExampleController
    {
        if (!self::$instance) {
            self::$instance = new ExampleController();
        }

        return self::$instance;
    }
}
