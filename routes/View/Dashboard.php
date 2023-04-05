<?php
use Source\Core\Translate;
if(!isset($route)){
    return false;
}
$translate = Translate::getInstance();
$route->namespace('Source\View\Dashboard');
$route->get($translate->router('/dashboard'),'View@home',type: "json");
$route->get($translate->router('/dashboard/register'),'View@register',type: "json");
$route->get($translate->router('/dashboard/forgot-password'),'View@forgotPassword',type: "json");
$route->get($translate->router('/dashboard/account-profile'),'View@accountProfile',type: "json");