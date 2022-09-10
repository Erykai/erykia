<?php
if (!isset($route)) {
    return false;
}
$route->namespace('Source\Controller\Module');
$route->default( '/module','ModuleController',[true, true, true, true], type: 'json', translate: false);