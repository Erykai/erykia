<?php
if(!isset($route)){
    return false;
}
$route->namespace("Source\Controller\Web");
$route->post('/component/language','LanguageController@translate',type: "json");
