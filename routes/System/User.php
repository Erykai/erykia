<?php
use Source\Core\Translate;
if(!isset($route)){
    return false;
}
$route->namespace("Source\Controller\System");
$route->default('/users', 'UserController', [false,false,true,true]);
$route->post((new Translate())->router('/register'),'UserController@store', type: "json");
$route->post((new Translate())->router('/recovery'),'UserController@recovery', type: "json");