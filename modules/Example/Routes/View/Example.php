<?php
use Source\Core\Translate;
if(!isset($route)){
    return false;
}
$path = dirname(__DIR__, 2)."/".TRANSLATE_PATH;
$translate = Translate::getInstance($path);
$route->namespace('Modules\Example\View');

$route->get($translate->router('/dashboard/examples/all', "", 'Example'),'View@all',type: "json");
$route->get($translate->router('/dashboard/examples/store', "", "Example"),'View@store',type: "json");
$route->get($translate->router('/dashboard/examples/trash', "","Example"),'View@trash',type: "json");
$route->get($translate->router('/dashboard/examples/read/{id}',"/{id}", "Example"),'View@read',type: "json");
$route->get($translate->router('/dashboard/examples/edit/{id}', "/{id}", "Example"),'View@edit',type: "json");
$route->get($translate->router('/dashboard/examples/destroy/{id}', "/{id}", "Example"),'View@destroy',type: "json");

