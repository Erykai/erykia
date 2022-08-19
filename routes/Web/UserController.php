<?php

use Source\Core\Translate;

$route->namespace("Source\Controller\Web");
//users
$route->default('/users', 'UserController', [false,false,true,true], "json");
$route->get((new Translate())->router('/users/{id}/{slug}', "/{id}/{slug}"), 'UserController@read', type: "json");