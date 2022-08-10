<?php

use Source\Controller\WebController;
use Source\Core\Route;

require "vendor/autoload.php";
$route = new Route();
$route->namespace('Source\Controller');
$route->get('/','WebController@home');
$route->namespace("Source\Controller\Web");
//users
$route->default('/usuario/cadastro', 'UserController', [false,false,true,true]);
$route->get('/usuario/cadastro/{id}/{slug}', 'UserController@read');
$route->default('/blog/categoria', 'PostCategoryController', [false,true,true,true]);
$route->default('/blog/post', 'PostController', [false,true,true,true]);


//login
$route->post('/usuario/login','LoginController@login');
$route->get('/usuario/sair','LoginController@logout');

$route->exec();

if ($route->error()) {
    var_dump($route->error());
}