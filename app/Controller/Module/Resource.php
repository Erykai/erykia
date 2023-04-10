<?php

namespace Source\Controller\Module;

use Source\Core\Controller;
use Source\Core\Helper;
use Source\Core\Pluralize;
use Source\Core\Translate;

abstract class Resource extends Controller
{
    /**
     * @var string
     */
    private string $path;
    /**
     * @var string
     */
    private string $component;
    /**
     * @var array
     */
    private array $modelNotNull;
    /**
     * @var array
     */
    private array $database;

    /**
     * start create module
     */
    protected function start(): void
    {
        if (!$this->validate()) {
            return;
        }

        foreach ($this->files() as $file) {
            $isDatabase = false;
            $isModel = false;
            if (str_contains($file, "Database")) {
                $isDatabase = true;
            }
            if (str_contains($file, "Model")) {
                $isModel = true;
            }
            $this->create($file, $isDatabase, $isModel);
        }
    }

    /**
     * @return string
     */
    protected function getComponent(): string
    {
        return $this->component;
    }

    /**
     * @param string $file
     */
    protected function setComponent(string $file): void
    {

        $Namespace = ucfirst(strtolower($this->data->component));
        $examples = (new Pluralize())->plural(strtolower($this->data->component));
        $Example = ucfirst(strtolower($this->data->component));
        if (str_contains($this->data->component, "_")) {
            $examples = explode("_", $examples);
            $examples = (new Pluralize())->plural(strtolower($examples[0])) . "_" . $examples[1];

            $Example = explode("_", $Example);
            $Example = $Example[0] . ucfirst(strtolower($Example[1]));
        }

        $this->component = str_replace([
            "Namespace",
            "Example",
            "examples"
        ], [
            $Namespace,
            $Example,
            $examples
        ], $file);
    }

    /**
     * @param $file
     * @param $isDatabase
     * @param $isModel
     */
    protected function create($file, $isDatabase, $isModel): void
    {
        $this->data->file = file_get_contents(dirname(__DIR__, 3) . $this->path . $file);

        $this->setComponent($file);
        $this->createDir();
        $this->setComponent(dirname(__DIR__, 3) . '/modules/' . $this->getComponent());
        file_put_contents($this->getComponent(), $this->replace());
        if ($isDatabase) {
            $this->database();
        }
        if ($isModel) {
            $this->model();
        }

    }

    /**
     *
     */
    protected function database(): void
    {
        if (str_contains($this->getComponent(), "categories")) {
            $data = $this->data->category;
        } else {
            $data = $this->data->database;
        }

        foreach ($data as $key => $column) {
            $this->database[] = '$migration->column("' . $key . '")->type("' . $column->type . '")->default()' . (isset($column->null) ? '->null()' : '') . ';';
            if (!isset($column->null)) {
                $this->modelNotNull[] = "'" . $key . "',";
            }
        }
        $database = implode(PHP_EOL, $this->database);
        $file = str_replace('/*###*/', $database, file_get_contents($this->getComponent()));
        file_put_contents($this->getComponent(), $file);


        if (!empty($this->data->category)) {
            unset($this->database);
            $this->categories();
            unset($this->database);
        }

    }

    /**
     *
     */
    protected function model(): void
    {
        if (str_contains($this->getComponent(), "Category")) {
            $data = $this->data->category;
        } else {
            $data = $this->data->database;
        }
        foreach ($data as $key => $column) {
            if (!isset($column->null)) {
                $this->modelNotNull[] = "'" . $key . "',";
            }
        }
        if (isset($this->modelNotNull)) {
            $model = implode(PHP_EOL, $this->modelNotNull);
            $file = str_replace('/*#####*/', $model, file_get_contents($this->getComponent()));
            if (file_put_contents($this->getComponent(), $file) === false) {
                throw new RuntimeException("error creating " . $this->getComponent());
            }
            unset($this->modelNotNull);
        }

    }

    /**
     *
     */
    protected function categories(): void
    {
        $relationships = Helper::relationship((array)$this->data->database, $this->data->component);
        if (isset($relationships->relationship)) {
            if (!str_contains($this->getComponent(), "categories")) {
                foreach ($relationships->relationship as $key => $relationship) {
                    $this->database[] = '$migration->addKey("' . (new Pluralize())->plural(strtolower($this->data->component)) . '_' . $relationship . '", "' . $key . '", "' . $relationship . '", "id");';
                }
                $database = implode(PHP_EOL, $this->database);
                $file = str_replace('/*####*/', $database, file_get_contents($this->getComponent()));
                file_put_contents($this->getComponent(), $file);
            }

        }


    }

    /**
     *
     */
    protected function createDir(): void
    {
        $component = ucfirst(strtolower($this->data->component));
        if (str_contains($this->data->component, "_")) {
            $component = explode("_", $component);
            $component = ucfirst(strtolower($component[0])) . ucfirst(strtolower($component[1]));
        }

        $modulePath = dirname(__DIR__, 3) . '/modules/' . $component;
        $this->dir($modulePath);
        $path = $modulePath . '/Controller';
        $this->dir($path);
        $path = $modulePath . '/Controller/' . $component . 'Trait';
        $this->dir($path);
        $path = $modulePath . '/Model';
        $this->dir($path);
        $path = $modulePath . '/Database';
        $this->dir($path);
        $path = $modulePath . '/Routes';
        $this->dir($path);
        $path = $modulePath . '/Routes/Controller';
        $this->dir($path);
        $path = $modulePath . '/Routes/View';
        $this->dir($path);
        $path = $modulePath . '/Public';
        $this->dir($path);
        $path = $modulePath . '/Public/dashboard';
        $this->dir($path);
        $path = $modulePath . '/Public/dashboard/pages';
        $this->dir($path);
        $path = $modulePath . '/View';
        $this->dir($path);
        $path = $modulePath . '/View/ViewTrait';
        $this->dir($path);
    }

    private function dir($path): void
    {
        if(is_dir($path)){
            return;
        }
        if (!is_dir($path) && !mkdir($path, 0755) && !is_dir($path)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $path));
        }
    }

    /**
     * @return array|string
     */
    protected function replace(): array|string
    {
        $Namespace = ucfirst(strtolower($this->data->component));
        $examples = (new Pluralize())->plural(strtolower($this->data->component));
        $Example = ucfirst(strtolower($this->data->component));
        $example = strtolower($this->data->component);
        if (str_contains($this->data->component, "_")) {
            $examples = explode("_", $examples);
            $examples = (new Pluralize())->plural(strtolower($examples[0])) . "_" . $examples[1];

            $Example = explode("_", $Example);
            $Example = $Example[0] . ucfirst(strtolower($Example[1]));
        }

        return str_replace(
            ['Namespace', 'examples', 'Example', 'example'],
            [
                $Namespace,
                $examples,
                $Example,
                $example
            ],
            $this->data->file
        );
    }

    /**
     * @return string[]
     */
    protected function files(): array
    {
        $this->path = "/modules/";
        return [
            "Example/Routes/Controller/Example.php",
            "Example/Routes/View/Example.php",
            "Example/Controller/ExampleController.php",
            "Example/Controller/ExampleTrait/Store.php",
            "Example/Controller/ExampleTrait/Read.php",
            "Example/Controller/ExampleTrait/Edit.php",
            "Example/Controller/ExampleTrait/Destroy.php",
            "Example/View/Resource.php",
            "Example/View/View.php",
            "Example/View/ViewTrait/All.php",
            "Example/View/ViewTrait/Destroy.php",
            "Example/View/ViewTrait/Edit.php",
            "Example/View/ViewTrait/Read.php",
            "Example/View/ViewTrait/Store.php",
            "Example/View/ViewTrait/Trash.php",
            "Example/Model/Example.php",
            "Example/Database/examples.php",
            "Example/Public/dashboard/menu.php",
            "Example/Public/dashboard/pages/all.php",
            "Example/Public/dashboard/pages/destroy.php",
            "Example/Public/dashboard/pages/edit.php",
            "Example/Public/dashboard/pages/read.php",
            "Example/Public/dashboard/pages/store.php",
            "Example/Public/dashboard/pages/trash.php"
        ];
    }

    /**
     * @return bool
     */
    protected function validate(): bool
    {
        if (!isset($this->data->component, $this->data->database)) {
            $this->setResponse(401, "error", "component, namespace and database is mandatory", "module");
            echo Translate::getInstance()->translator($this->getResponse(), "message")->json();
            return false;
        }
        return true;
    }
}