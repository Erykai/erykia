<?php

namespace Source\Controller\System;

use Source\Core\Controller;
use Source\Core\Translate;

class LanguageController extends Controller
{
    public function translate($query, string $response)
    {
        $this->setRequest($query);
        $dynamic = $this->data->dynamic ?? "";
        $json = Translate::getInstance()->translator($this->data, "component")->json();
        echo str_replace("<#>", $dynamic, $json);
    }
}