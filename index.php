<?php

use Source\Core\Response;
use Source\Core\Route;
require "vendor/autoload.php";

$route = new Route();

/**
 * AUTO INCLUDE
 */

$configPaths = __DIR__ . '/routes';

foreach (scandir($configPaths) as $configPath) {
    $dirPaths = __DIR__ . '/routes/' . $configPath;
    foreach (scandir($dirPaths) as $configFile) {
        $file = $dirPaths . '/' . $configFile;
        if (is_file($file) && pathinfo($file, PATHINFO_EXTENSION) == 'php') {
            require_once $file;
        }
    }
}

$route->exec();

if ($route->response()->type === "error") {
    $response = new Response();
    $response->data($route->response())->lang();
    echo $response->json();
}