<?php
use Source\Core\Route;
use Source\Core\Translate;
$root = __DIR__;
require "$root/vendor/autoload.php";

$route = new Route();

/**
 * AUTO INCLUDE
 */

$configPaths = "$root/routes";
//home
$route->namespace('Source\Controller\Web');
$route->get('/','WebController@home',type: 'json');

$files = [];
foreach (scandir($configPaths) as $configPath) {
    $dirPaths = $root . '/routes/' . $configPath;
    if (is_file($dirPaths)) {
        $file = $dirPaths;
        $files[] = $file;
    }
    if (is_dir($dirPaths)) {
        foreach (scandir($dirPaths) as $configFile) {
            $file = $dirPaths . '/' . $configFile;
            if (is_file($file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                if (!str_contains($file, "/../")) {
                    $files[] = $file;
                }

            }
        }
    }

}
foreach ($files as $file) {
    require $file;
}
$route->exec();

if ($route->response()->type === "error") {
    echo (new Translate())->translator($route->response(), "message")->json();
}