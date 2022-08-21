<?php
use Source\Core\Translate;
if(!isset($route)){
    return false;
}
$route->namespace("Source\Controller\Web");
//users
$route->default('/posts-categories', 'PostCategoryController', [false,false,true,true]);
$route->get((new Translate())->router('/posts-categories/{id}/{slug}', '/{id}/{slug}'), 'PostCategoryController@read', type: "json");
