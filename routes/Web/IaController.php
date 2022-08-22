<?php
if (!isset($route)) {
    return false;
}
$route->namespace('Source\Controller\Ia');
$route->default('/ia', 'IaController', [false, false, true, true]);