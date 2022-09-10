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
        //validate return components ex response
        if (isset($response->message)) {
            $response->text = $response->message;
            unset($response->message);
        }
        if (!isset($response->text)) {
            die('to use the Translate component send an object that contains the example attribute $data->text = "route";');
        }
        $return = new Response();
        $response->file = $nameDefault;
        $return->data($this->data($response)->target()->response());
        unset($return->object()->message, $return->object()->nameDefault);
        if ($nameDefault === 'message') {
            $response->text = $return->getResponse()->translate;
            $return->data($response);
        }

        return $return;

    }

    public function router(string $route, string $dynamic = null)
    {
        $routerTranslate = new stdClass();
        if ($dynamic) {
            $routerTranslate->dynamic = $dynamic;
        }
        $routerTranslate->text = $route;
        $router = $this->translator($routerTranslate, "route")->object()->translate;
        if (strpos($router, "<&>")) {
            die($router . " in variable " . '$routeDefault and $routeTranslate');
        }

        return $router;
    }
}