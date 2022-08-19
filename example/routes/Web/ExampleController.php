<?php
$route->namespace("Source\Controller\Web");
//users
$route->default('/exemplo/cadastro', 'ExampleController', [false,false,true,true], "json");
$route->get('/exemplo/cadastro/{id}/{slug}', 'ExampleController@read', response: "json");
