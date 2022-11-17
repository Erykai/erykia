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
$route->namespace('Source\Controller\System');
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
    http_response_code($route->response()->code);
    echo (new Translate())->translator($route->response(), "message")->json();
}