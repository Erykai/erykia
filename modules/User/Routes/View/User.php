<?php
use Source\Core\Translate;
if(!isset($route)){
    return false;
}
$route->namespace('Modules\User\View');
$route->get((new Translate())->router('/dashboard/users/all'),'View@all',type: "json");
$route->get((new Translate())->router('/dashboard/users/edit/{id}'),'View@edit',type: "json");
$route->get((new Translate())->router('/dashboard/users/destroy/{id}'),'View@destroy',type: "json");
