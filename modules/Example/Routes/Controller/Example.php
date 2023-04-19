<?php
use Source\Core\Translate;
if(!isset($route)){
    return false;
}
$path = dirname(__DIR__, 2)."/".TRANSLATE_PATH;
$translate = Translate::getInstance($path);
$route->namespace("Modules\Example\Controller");
$route->default('/examples', 'ExampleController', [true,true,true,true], path: $path);
$route->get($translate->router('/examples/all/{trash}', "/{trash}", 'Example'),'ExampleController@read', type: "json");
$route->post($translate->router('/examples/image/upload', "", 'Example'),'ExampleController@upload', type: "json");
