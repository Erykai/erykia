<?php

require __DIR__ . '/vendor/autoload.php';
//remove
//create.php?remove=true&class=template&route=templates&singular=Template&plural=Templates
//create
//create.php?create=true&class=template&route=templates&singular=Template&plural=Templates

if (isset($_GET["create"]) || isset($_GET["remove"])) {
    $class = $_GET["class"];
    $route = $_GET["route"];
    $singular = $_GET["singular"];
    $plural = $_GET["plural"];

    $controller = new \App\Modules\ControllerController($class, $route, $singular, $plural);
    $files = [
        '/examples/app/Controllers/Admin/ExampleController.php',
        '/examples/app/Models/Example.php',
        '/examples/config/theme-example.php',
        '/examples/config/theme-example.php',
        '/examples/database/migrations/examples.php',
        '/examples/routes/admin/ExampleController.php',
        '/examples/themes/admin/pages/examples/_form.php',
        '/examples/themes/admin/pages/examples/create.php',
        '/examples/themes/admin/pages/examples/edit.php',
        '/examples/themes/admin/pages/examples/index.php',
        '/examples/themes/admin/partials/nav/examples.php'
    ];
    if (isset($_GET["create"])) {
        $controller->create($files);

        $model = new \App\Modules\Model($class, $route, $singular, $plural);
        $columns = [
            'content' => false,
            'description' => false,
            'bg_color' => true,
            'font_color' => true,
        ];
        $model->create($columns);
        $database = new \App\Modules\Database($class, $route, $singular, $plural);
        $database->create($columns);
        shell_exec('/opt/cpanel/ea-php81/root/usr/bin/php vendor/bin/phinx migrate');
    }

    if (isset($_GET["remove"])) {
//remover tudo que foi criado
        $controller->delete($files);
        $database = new \App\Modules\Database($class, $route, $singular, $plural);
        $database->delete();
        shell_exec('/opt/cpanel/ea-php81/root/usr/bin/php vendor/bin/phinx migrate');
    }

}