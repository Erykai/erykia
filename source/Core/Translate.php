<?php

namespace Source\Core;

use stdClass;

class Translate extends \Erykai\Translate\Translate
{
    public function translator(object $response, string $nameDefault)
    {
        $return = new Response();
        $response->nameDefault = $nameDefault;
        $response->translate = $response->message;
        $return->data($this->data($response)->lang()->response());
        unset($return->object()->message, $return->object()->nameDefault);
        return $return;
    }

    public function router(string $route, string $dynamic = null)
    {
        $routerTranslate = new stdClass();
        if($dynamic){
            $routerTranslate->dynamic = $dynamic;
        }
        $routerTranslate->message = $route;
        $router = $this->translator($routerTranslate, "route")->object()->translate;
        if(strpos($router, "<&>")){
            die($router . " in variable " . '$routeDefault and $routeTranslate');
        }

        return $router;
    }
}