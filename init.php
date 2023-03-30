<?php

use Source\Core\Route;
use Source\Core\Translate;
use Source\Model\User;
$root = __DIR__;
require "$root/vendor/autoload.php";
$route = new Route();

if($_SERVER["REQUEST_METHOD"] !== "POST" && $_GET['route'] !== "ia" && !getenv("CONN_USER")){
    header("Location: /ia");
}else{
    if(getenv("CONN_USER")){
        $users = new User();
        $user = $users->find('id', 'id=:id',['id'=>1])->fetch();
        if($_SERVER["REQUEST_METHOD"] !== "POST" && !$user && $_GET['route'] !== "ia"){
            header("Location: /ia");
        }
    }

}

/**
 * AUTO INCLUDE
 */

$configPaths = "$root/routes";
//home
$route->namespace('Source\View\Web');
$route->get('/','View@home',type: 'json');
// route system
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
//route modules
$configPaths = "$root/modules";
$files = [];
foreach (scandir($configPaths) as $configPath) {
    $dirPaths = $root . '/modules/' . $configPath;

    if (is_dir($dirPaths)) {
        // Loop through each folder and look for PHP files in "Routes" folder
        foreach (scandir($dirPaths) as $folder) {
            $routesFolder = $dirPaths . '/' . $folder . '/Routes';
            if (is_dir($routesFolder)) {
                foreach (scandir($routesFolder) as $configFile) {
                    $file = $routesFolder . '/' . $configFile;
                    if (is_file($file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                        if (!str_contains($file, "/../")) {
                            $files[] = $file;
                        }
                    }
                }
            }
        }

        // Look for PHP files in the main folder (in case there are any)
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
    http_response_code($route->response()->code);
    echo (new Translate())->translator($route->response(), "message")->json();
}