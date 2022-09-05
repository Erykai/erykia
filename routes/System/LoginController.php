<?php
use Source\Core\Translate;
if(!isset($route)){
    return false;
}
$route->namespace("Source\Controller\System");
//login
$route->post((new Translate())->router('/login'),'LoginController@login', type: "json");
$route->get((new Translate())->router('/logout'),'LoginController@logout',type: "json");
