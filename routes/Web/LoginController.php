<?php

use Source\Core\Translate;

$route->namespace("Source\Controller\Web");
//login
$route->post((new Translate())->router('/login'),'LoginController@login', type: "json");
$route->get((new Translate())->router('/logout'),'LoginController@logout',type: "json");
