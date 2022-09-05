<?php
if (!isset($route)) {
    return false;
}
$route->namespace('Source\Controller\Ia');
$route->get('/ia','IaController@read',type: 'json');
$route->post('/ia/database','IaDatabaseController@store',type: 'json');
$route->post('/ia/user','IaUserController@store',type: 'json');

$route->namespace('Source\Controller\Web');
$route->post('/ia/login','LoginController@login', type: "json");