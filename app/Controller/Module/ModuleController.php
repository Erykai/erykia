<?php

namespace Source\Controller\Module;

use Source\Controller\Module\ModuleTrait\Component;
use Source\Controller\Module\ModuleTrait\Database;
use Source\Controller\Module\ModuleTrait\Directory;
use Source\Controller\Module\ModuleTrait\Files;
use Source\Controller\Module\ModuleTrait\Model;
use Source\Controller\Module\ModuleTrait\Store;
use stdClass;


/**
 * create news modules erykia
 */
class ModuleController extends Resource
{
    use Store;
    use Files;
    use Directory;
    use Model;
    use Component;
    use Database;

    private static ?ModuleController $instance = null;
    private stdClass $replace;

    private function __construct()
    {
        parent::__construct();
    }

    public static function getInstance(): ModuleController
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}