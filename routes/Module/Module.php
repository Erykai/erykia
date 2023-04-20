<?php
if (!isset($route)) {
    return false;
}
$route->namespace('Source\Controller\Module');
$route->default( '/module','ModuleController',[true, false, true, true], type: 'json', translate: false);
