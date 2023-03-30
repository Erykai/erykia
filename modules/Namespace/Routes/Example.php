<?php
if(!isset($route)){
    return false;
}
$route->namespace("Modules\Namespace\Controller");
$route->default('/examples', 'ExampleController', [false,true,true,true]);