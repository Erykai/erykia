<?php

use Source\Core\CreateDatabase;
use Source\Core\Response;
use Source\Core\Route;
//response -> object, json, array
require "vendor/autoload.php";

$create = new CreateDatabase();
$create->table('users');
$create->column('id')->type('int(11)')->default()->null(false)->extra();
$create->column('name')->type('varchar(255)')->default()->null(false)->extra();
$create->column('password')->type('text')->default()->null(false)->extra();
$create->column('email')->type('varchar(255)')->default()->null(false)->extra();
$create->column('level')->type('int(11)')->default()->null(false)->extra();
$create->column('profile')->type('varchar(255)')->default('NULL')->null(true)->extra();
$create->column('cover')->type('varchar(255)')->default('NULL')->null(true)->extra();
$create->save();


die();
$route = new Route();
$route->namespace('Source\Controller');
$route->get('/','WebController@home');
$route->namespace("Source\Controller\Web");
//users
$route->default('/usuario/cadastro', 'UserController', [false,false,true,true], "json");
$route->get('/usuario/cadastro/{id}/{slug}', 'UserController@read', response: "json");
$route->default('/blog/categoria', 'PostCategoryController', [false,true,true,true]);
$route->default('/blog/post', 'PostController', [false,true,true,true]);


//login
$route->post('/usuario/login','LoginController@login');
$route->get('/usuario/sair','LoginController@logout');

$route->exec();

if ($route->response()->type === "error") {
    $response = new Response("object");
    $response->lang();
    echo $response->answer($route->response())->message;
}