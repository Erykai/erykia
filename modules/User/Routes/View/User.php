<?php
use Source\Core\Translate;
if(!isset($route)){
    return false;
}
$route->namespace('Modules\User\View');
$path = dirname(__DIR__, 2)."/".TRANSLATE_PATH;
$route->get((new Translate($path))->router('/dashboard/users/all'),'View@all',type: "json");
$route->get((new Translate($path))->router('/dashboard/users/edit/{id}', "/{id}"),'View@edit',type: "json");
$route->get((new Translate($path))->router('/dashboard/users/destroy/{id}', "/{id}"),'View@destroy',type: "json");
