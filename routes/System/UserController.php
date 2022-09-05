<?php
if(!isset($route)){
    return false;
}
$route->namespace("Source\Controller\System");
$route->default('/users', 'UserController', [false,false,true,true]);