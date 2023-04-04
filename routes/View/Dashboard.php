<?php
use Source\Core\Translate;
if(!isset($route)){
    return false;
}
$route->namespace('Source\View\Dashboard');
$route->get((new Translate())->router('/dashboard'),'View@home',type: "json");
$route->get((new Translate())->router('/dashboard/register'),'View@register',type: "json");
$route->get((new Translate())->router('/dashboard/forgot-password'),'View@forgotPassword',type: "json");
$route->get((new Translate())->router('/dashboard/account-profile'),'View@accountProfile',type: "json");