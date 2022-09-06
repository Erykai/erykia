<?php
if (!isset($route)) {
    return false;
}
$route->namespace('Source\Controller\Module');
$route->default( '/module','ModuleController',type: 'json', translate: false);