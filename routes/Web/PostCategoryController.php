<?php

use Source\Core\Translate;

$route->namespace("Source\Controller\Web");
//users
$route->default('/posts-categories', 'PostCategoryController', [false,false,true,true], "json");
$route->get((new Translate())->router('/posts-categories/{id}/{slug}', '/{id}/{slug}'), 'PostCategoryController@read', type: "json");
