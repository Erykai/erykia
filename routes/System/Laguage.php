<?php
if(!isset($route)){
    return false;
}
$route->namespace("Source\Controller\System");
$route->post('/component/language','LanguageController@translate',type: "json");
