<?php
use Source\Core\Translate;
if(!isset($route)){
    return false;
}
$route->namespace('Modules\User\View');
$route->get((new Translate())->router('/users/edit/{id}'),'View@userEdit',type: "json");
$route->get((new Translate())->router('/users/destroy/{id}'),'View@userDestroy',type: "json");