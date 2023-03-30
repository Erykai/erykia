<?php
use Source\Core\Translate;
if(!isset($route)){
    return false;
}
$route->namespace('Source\View\Dashboard');
$route->get((new Translate())->router('/dashboard'),'View@home',type: "json");