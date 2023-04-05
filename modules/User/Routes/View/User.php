<?php
use Source\Core\Translate;
if(!isset($route)){
    return false;
}
$path = dirname(__DIR__, 2)."/".TRANSLATE_PATH;
$translate = Translate::getInstance($path);
$route->namespace('Modules\User\View');

$route->get($translate->router('/dashboard/users/all'),'View@all',type: "json");
$route->get($translate->router('/dashboard/users/edit/{id}', "/{id}"),'View@edit',type: "json");
$route->get($translate->router('/dashboard/users/destroy/{id}', "/{id}"),'View@destroy',type: "json");
