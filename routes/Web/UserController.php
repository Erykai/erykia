<?php
use Source\Core\Translate;
if(!isset($route)){
    return false;
}
$route->namespace("Source\Controller\Web");
$route->default('/users', 'UserController', [false,false,true,true]);
$route->get((new Translate())->router('/users/{id}/{slug}', "/{id}/{slug}"), 'UserController@read', type: "json");