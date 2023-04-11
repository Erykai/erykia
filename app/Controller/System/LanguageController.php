<?php

namespace Source\Controller\System;

use Source\Core\Controller;
use Source\Core\Translate;

class LanguageController extends Controller
{
    private static $instance;

    protected function __construct()
    {
        parent::__construct();
    }

    public static function getInstance(): LanguageController
    {
        if (!self::$instance) {
            self::$instance = new LanguageController();
        }

        return self::$instance;
    }

    public function translate($query, string $response)
    {
        $this->setRequest($query);
        $dynamic = $this->data->dynamic ?? "";
        $json = Translate::getInstance()->translator($this->data, "component")->json();
        echo str_replace("<#>", $dynamic, $json);
    }
}
