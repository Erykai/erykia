<?php
if(!isset($route)){
    return false;
}
$route->namespace("Source\Controller\Web");
$route->default('/users', 'UserController', [false,false,true,true]);