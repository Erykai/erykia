<?php
use Source\Core\Translate;
if(!isset($route)){
    return false;
}
$route->namespace("Modules\User\Controller");
$path = dirname(__DIR__, 2)."/".TRANSLATE_PATH;
$route->default('/users', 'UserController', [false,false,true,true], path: $path);
$route->post((new Translate($path))->router('/register'),'UserController@store', type: "json");
$route->post((new Translate($path))->router('/recovery'),'UserController@recovery', type: "json");
