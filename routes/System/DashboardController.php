<?php
use Source\Core\Translate;
if(!isset($route)){
    return false;
}
$route->namespace("Source\Controller\System");
$route->get((new Translate())->router('/dashboard'),'DashboardController@home',type: "json");