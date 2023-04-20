<?php
use Source\Core\Translate;
if(!isset($route)){
    return false;
}
$path = dirname(__DIR__, 2)."/".TRANSLATE_PATH;
$translate = Translate::getInstance($path);
$route->namespace("Modules\User\Controller");
$route->default('/users', 'UserController', [true,true,true,true], path: $path);
$route->get($translate->router('/users/all/{trash}', "/{trash}", 'User'),'UserController@read', type: "json");
$route->post($translate->router('/users/image/upload', "", 'User'),'UserController@upload', type: "json");
