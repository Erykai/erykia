<?php
use Source\Core\Translate;
if(!isset($route)){
    return false;
}
$translate = Translate::getInstance();
$route->namespace('Source\View\Web');
$route->get('/', 'View@home', type: 'json');
$route->get($translate->router('/blog'),'View@blog',type: "json");
$route->get($translate->router('/booking'),'View@booking',type: "json");
$route->get($translate->router('/contact'),'View@contact',type: "json");
$route->get($translate->router('/galery'),'View@galery',type: "json");
$route->get($translate->router('/bedroom'),'View@bedroom',type: "json");