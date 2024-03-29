<?php

use Modules\User\Model\User;
use Source\Core\Route;
use Source\Core\Translate;

$root = __DIR__;
require "$root/vendor/autoload.php";
$route = new Route();
$translate = Translate::getInstance();

if (shouldRedirectToIA()) {
    header("Location: /ia");
}

function shouldRedirectToIA(): bool
{
    if ($_SERVER["REQUEST_METHOD"] === "POST" || $_GET['route'] === "ia") {
        return false;
    }

    if (!getenv("CONN_USER")) {
        return true;
    }

    $users = new User();
    $user = $users->find('id')->fetch();

    return !$user;
}

function loadFilesFromFolders(array $folders): array
{
    $files = [];

    foreach ($folders as $folder) {
        $directoryIterator = new RecursiveDirectoryIterator($folder, RecursiveDirectoryIterator::SKIP_DOTS);
        $iteratorIterator = new RecursiveIteratorIterator($directoryIterator);

        foreach ($iteratorIterator as $file) {
            $filePath = $file->getPathname();

            if ($file->getExtension() === 'php' && !str_contains($filePath, "/../")) {
                if (str_contains($filePath, "/Routes/") || preg_match('/\/routes\/[^\/]+\/[^\/]+\.php$/', $filePath)) {
                    if(!str_contains($filePath, "/Example/")){
                        $files[] = $filePath;
                    }
                }
            }
        }
    }

    return $files;
}


require "$root/routes/View/Web.php";

$foldersToLoad = ["$root/routes", "$root/modules"];
$filesToInclude = loadFilesFromFolders($foldersToLoad);

foreach ($filesToInclude as $file) {
    require_once $file;
}

$route->exec();

if ($route->response()->type === "error") {
    http_response_code($route->response()->code);
    echo $translate->translator($route->response(), "message")->json();
}