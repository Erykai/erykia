<?php

namespace Source\Controller\Module;

use RuntimeException;
use Source\Core\Controller;
use Source\Core\Helper;
use Source\Core\Pluralize;
use Source\Core\Translate;
use stdClass;

/**
 * create news modules erykia
 */
class ModuleController extends Controller
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
     * @param $query
     */
    public function store($query): void
    {
        $this->setRequest($query);
        if ($this->data->category) {
            $this->data->component .= "_category";
            $this->start();
        }
        $this->data->component = str_replace("_category","",$this->data->component);
        $this->start();

        $return = new stdClass();
        $return->code = 200;
        $return->type = "success";
        $return->text = $this->data->component . " created successfully";
        $return->dynamic = $this->data->component;
        $translate = new Translate();
        echo $translate->translator($return,"message")->json();
    }

    /**
     *
     */
    private function start(): void
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
    private function getComponent(): string
    {
        return $this->component;
    }

    /**
     * @param string $file
     */
    private function setComponent(string $file): void
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
    private function create($file, $isDatabase, $isModel): void
    {
        $this->data->file = file_get_contents(dirname(__DIR__, 3) . $this->path . $file);
        $this->setComponent($file);
        $this->createDir();
        $this->setComponent(dirname(__DIR__, 3) . '/' . $this->getComponent());
        file_put_contents($this->getComponent(), $this->replace());
        if ($isDatabase) {
            $this->database();
        }
        if ($isModel) {
            $this->model();
        }
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

    /**
     *
     */
    private function database(): void
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
    private function model(): void
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
            file_put_contents($this->getComponent(), $file);
            unset($this->modelNotNull);
        }

    }

    /**
     *
     */
    private function categories(): void
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
    private function createDir(): void
    {
        if (str_contains($this->getComponent(), "app/Controller/")) {
            $dirPath = dirname(__DIR__, 2) . '/Controller/' . ucfirst(strtolower($this->data->namespace));
            if (!is_dir($dirPath) && !mkdir($dirPath, 0755) && !is_dir($dirPath)) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $dirPath));
            }
        }
        if (str_contains($this->getComponent(), "routes/")) {
            $dirPath = dirname(__DIR__, 3) . '/routes/' . ucfirst(strtolower($this->data->namespace));
            if (!is_dir($dirPath) && !mkdir($dirPath, 0755) && !is_dir($dirPath)) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $dirPath));
            }
        }
    }

    /**
     * @return array|string
     */
    private function replace(): array|string
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
    private function files(): array
    {
        $this->path = "/erykia/Module/";
        return [
            "app/Controller/Route/ExampleController.php",
            "app/Model/Example.php",
            "database/examples.php",
            "routes/Route/ExampleController.php"
        ];
    }

    /**
     * @return bool
     */
    private function validate(): bool
    {
        if (!isset($this->data->component, $this->data->namespace, $this->data->database)) {
            $this->setError(401, "error", "component, namespace and database is mandatory");
            echo $this->translate->translator($this->getError(), "message")->json();
            return false;
        }
        return true;
    }
}