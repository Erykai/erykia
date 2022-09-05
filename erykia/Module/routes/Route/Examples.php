<?php
if(!isset($route)){
    return false;
}
$route->namespace("Source\Controller\Route");
$route->default('/exmples', 'Example', [false,true,true,true]);