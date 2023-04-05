<?php
use Source\Core\Translate;
if(!isset($route)){
    return false;
}
$translate = Translate::getInstance();
$route->namespace("Source\Controller\System");
$route->post($translate->router('/login'),'LoginController@login', type: "json");
$route->post($translate->router('/logout'),'LoginController@logout',type: "json");
