<?php
if(!isset($route)){
    return false;
}
$route->namespace("Source\Controller\Namespace");
$route->default('/examples', 'ExampleController', [false,true,true,true]);