<?php


use Source\Controller\Web;
use Source\Core\Route;

require "vendor/autoload.php";
$route = new Route();
$route->namespace('Source\Controller');
$route->get('/','Web@home');
$route->namespace(Web::class);
//users
$route->default('/usuario/cadastro', 'User', [false,false,true,true]);
$route->default('/blog/categoria', 'PostCategory', [false,true,true,true]);
$route->default('/blog/post', 'Post', [false,true,true,true]);


//login
$route->post('/usuario/login','Login@login');
$route->get('/usuario/sair','Login@logout');

$route->exec();

if ($route->error()) {
    var_dump($route->error());
}