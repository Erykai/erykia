<?php

use Source\Core\Response;
use Source\Core\Route;
require "vendor/autoload.php";

$route = new Route();
$route->namespace('Source\Controller');
$route->get('/','WebController@home');
$route->namespace("Source\Controller\Web");
//users
$route->default('/usuario/cadastro', 'UserController', [false,false,true,true], "json");
$route->get('/usuario/cadastro/{id}/{slug}', 'UserController@read', response: "json");


//login
$route->post('/usuario/login','LoginController@login');
$route->get('/usuario/sair','LoginController@logout');

$route->exec();

if ($route->response()->type === "error") {
    $response = new Response();
    $response->data($route->response())->lang();
    echo $response->json();
}