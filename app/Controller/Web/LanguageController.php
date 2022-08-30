<?php

namespace Source\Controller\Web;

use Source\Core\Controller;
use Source\Core\Translate;
use stdClass;

class LanguageController extends Controller
{
    public function translate($query, string $response)
    {
        $this->setRequest($query);
        $dynamic = $this->data->dynamic ?? "";
        $json = (new Translate())->translator($this->data, "component")->json();
        echo str_replace("<#>", $dynamic, $json);
    }
}