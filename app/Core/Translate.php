<?php

namespace Source\Core;

use stdClass;

class Translate extends \Erykai\Translate\Translate
{
    public function translatorString(string $message, string $file)
    {
        $response = new stdClass();
        $return = new Response();
        $response->file = $file;
        $response->text = $message;
        $return->data($this->data($response)->target()->response());
        unset($return->object()->message, $return->object()->nameDefault);
        return $return;
    }
    public function translator(object $response, string $nameDefault)
    {
        if(!isset($response->message))
        {
            die('to use the Translate component send an object that contains the example attribute $data->message = "route";');
        }
        $return = new Response();
        $response->nameDefault = $nameDefault;
        $response->translate = $response->message;
        $return->data($this->data($response)->lang(TRANSLATE_DEFAULT)->response());
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