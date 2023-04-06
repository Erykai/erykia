<?php
use Source\Core\Translate;
if(!isset($route)){
    return false;
}
$path = dirname(__DIR__, 2)."/".TRANSLATE_PATH;
$translate = Translate::getInstance($path);
$route->namespace('Modules\User\View');

$route->get($translate->router('/dashboard/users/all', "", 'User'),'View@all',type: "json");
$route->get($translate->router('/dashboard/users/store', "", "User"),'View@store',type: "json");
$route->get($translate->router('/dashboard/users/trash', "","User"),'View@trash',type: "json");
$route->get($translate->router('/dashboard/users/read/{id}',"/{id}", "User"),'View@read',type: "json");
$route->get($translate->router('/dashboard/users/edit/{id}', "/{id}", "User"),'View@edit',type: "json");
$route->get($translate->router('/dashboard/users/destroy/{id}', "/{id}", "User"),'View@destroy',type: "json");

