<?php
$route->namespace("Source\Controller\Web");
//users
$route->default('/usuario/cadastro', 'UserController', [false,false,true,true], "json");
$route->get('/usuario/cadastro/{id}/{slug}', 'UserController@read', response: "json");
//login
$route->post('/usuario/login','LoginController@login');
$route->get('/usuario/sair','LoginController@logout');