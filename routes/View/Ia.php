<?php
if (!isset($route)) {
    return false;
}
$route->namespace('Source\View\Ia');
$route->get('/ia','View@read',type: 'json');