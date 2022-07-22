<?php

use Erykai\Routes\Route;

require "vendor/autoload.php";
$route = new Route();
$route->namespace('Source\Controller');
$route->get('/','ControllerWeb@home');

$route->exec();

if ($route->error()) {
    var_dump($route->error());
}