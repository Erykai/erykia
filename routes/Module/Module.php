<?php
if (!isset($route)) {
    return false;
}
$route->namespace('Source\Controller\Module');
$route->default( '/module','ModuleController',[true, true, true, true], type: 'json', translate: false);

//Route::get('bash', function(){
//    $bash =  '#!/bin/bash'.PHP_EOL;
//    $bash .= 'echo "Hello, Im Erykia"'.PHP_EOL;
//    $bash .=  'git clone https://github.com/erykai/erykia.git bagual'.PHP_EOL;
//    $bash .=  'cd bagual'.PHP_EOL;
//    $bash .=  'docker-compose up -d --build'.PHP_EOL;
//    return $bash;
//});