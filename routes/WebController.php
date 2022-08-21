<?php
use Source\Core\Translate;

$route->namespace('Source\Controller');
$route->get('/','WebController@home',type: 'json');
$route->get((new Translate())->router('/about'),'WebController@about',type: 'json');
$route->get((new Translate())->router('/news'),'WebController@news',type: 'json');
$route->get((new Translate())->router('/contact'),'WebController@contact',type: 'json');
