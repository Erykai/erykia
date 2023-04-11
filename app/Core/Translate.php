<?php

namespace Source\Core;

use stdClass;

class Translate extends \Erykai\Translate\Translate
{
    private static ?Translate $instance = null;

    private function __construct(string $path = null) {
        parent::__construct($path);
    }


    public static function getInstance(string $path = null) {
        if (self::$instance === null) {
            self::$instance = new Translate($path);
        }
        return self::$instance;
    }

    public function translatorString(string $message, string $file)
    {
        $response = new stdClass();
        $return = Response::getInstance();
        $response->file = $file;
        $response->text = $message;
        $return->data($this->data($response)->target()->response());
        $return->object()->text = $return->object()->translate;
        unset($return->object()->message, $return->object()->nameDefault);
        return $return;
    }

    public function translator(object $response, string $nameDefault, string $module = null)
    {
        //validate return components ex response
        if (isset($response->message)) {
            $response->text = $response->message;
            unset($response->message);
        }
        if (!isset($response->text)) {
            die('to use the Translate component send an object that contains the example attribute $data->text = "route";');
        }
        $return = Response::getInstance();
        $response->file = $nameDefault;
        $return->data($this->data($response)->target(module:$module)->response());
        unset($return->object()->message, $return->object()->nameDefault);
        if ($nameDefault === 'message') {
            $response->text = $return->object()->translate;
            $return->data($response);
        }

        return $return;

    }

    public function router(string $route, string $dynamic = null, string $module = null)
    {
        $routerTranslate = new stdClass();
        if ($dynamic) {
            $routerTranslate->dynamic = $dynamic;
        }
        $routerTranslate->text = $route;
        $router = $this->translator($routerTranslate, "route", $module)->object()->translate;
        if (strpos($router, "<&>")) {
            die($router . " in variable " . '$routeDefault and $routeTranslate');
        }

        return $router;
    }
}