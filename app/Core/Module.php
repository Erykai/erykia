<?php

namespace Source\Core;
use RuntimeException;

/**
 * create module
 */
trait Module
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
            if (str_contains($file, "database")) {
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
        $Route = ucfirst(strtolower($this->data->namespace));
        $examples = (new Pluralize())->plural(strtolower($this->data->component));
        $Example = ucfirst(strtolower($this->data->component));
        if (str_contains($this->data->component, "_")) {
            $examples = explode("_", $examples);
            $examples = (new Pluralize())->plural(strtolower($examples[0])) . "_" . $examples[1];

            $Example = explode("_", $Example);
            $Example = $Example[0] . ucfirst(strtolower($Example[1]));
        }
        $this->component = str_replace([
            "Route",
            "Example",
            "examples"
        ], [
            $Route,
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
        $this->data->file = file_get_contents(dirname(__DIR__, 2) . $this->path . $file);
        $this->setComponent($file);
        $this->createDir();
        $this->setComponent(dirname(__DIR__, 2) . '/' . $this->getComponent());
        file_put_contents($this->getComponent(), $this->replace());
        if ($isDatabase) {
            $this->database();
        }
        if ($isModel) {
            $this->model();
            //create database
            $Example = ucfirst(strtolower($this->data->component));
            if(str_contains($Example,"_")){
                $Example = explode("_", $Example);
                $Example = $Example[0] . ucfirst(strtolower($Example[1]));
            }
            $class = $Example;
            $class = "\Source\Model\\" . $class;
            $Class = new $class();
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
            if(file_put_contents($this->getComponent(), $file) === false)
            {
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
        if (str_contains($this->getComponent(), "app/Controller/")) {
            $dirPath = dirname(__DIR__) . '/Controller/' . ucfirst(strtolower($this->data->namespace));
            if (!is_dir($dirPath) && !mkdir($dirPath, 0755) && !is_dir($dirPath)) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $dirPath));
            }
        }
        if (str_contains($this->getComponent(), "routes/")) {
            $dirPath = dirname(__DIR__, 2) . '/routes/' . ucfirst(strtolower($this->data->namespace));
            if (!is_dir($dirPath) && !mkdir($dirPath, 0755) && !is_dir($dirPath)) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $dirPath));
            }
        }
    }

    /**
     * @return array|string
     */
    protected function replace(): array|string
    {
        $Namespace = ucfirst(strtolower($this->data->namespace));
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
        $this->path = "/erykia/Module/";
        return [
            "app/Controller/Route/ExampleController.php",
            "database/examples.php",
            "app/Model/Example.php",
            "routes/Route/ExampleController.php"
        ];
    }

    /**
     * @return bool
     */
    protected function validate(): bool
    {
        if (!isset($this->data->component, $this->data->namespace, $this->data->database)) {
            $this->setResponse(401, "error", "component, namespace and database is mandatory", "module");
            echo (new Translate())->translator($this->getResponse(), "message")->json();
            return false;
        }
        return true;
    }
}