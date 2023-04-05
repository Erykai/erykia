<?php
use Source\Core\Translate;
if(!isset($route)){
    return false;
}
$path = dirname(__DIR__, 2)."/".TRANSLATE_PATH;
$translate = Translate::getInstance($path);
$route->namespace("Modules\User\Controller");
$route->default('/users', 'UserController', [false,false,true,true], path: $path);
$route->post($translate->router('/register'),'UserController@store', type: "json");
$route->post($translate->router('/recovery'),'UserController@recovery', type: "json");
