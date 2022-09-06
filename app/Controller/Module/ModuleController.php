<?php

namespace Source\Controller\Module;

use RuntimeException;
use Source\Core\Controller;
use Source\Core\Pluralize;

class ModuleController extends Controller
{
    private string $path;

    public function store($query, string $response)
    {
        $this->setRequest($query);
        if (!isset($this->data->component, $this->data->category, $this->data->namespace)) {
            $this->setError(401, "error", "component, category and namespace is mandatory");
            echo $this->translate->translator($this->getError(), "message")->json();
            return false;
        }
        foreach ($this->pathFileErykiaModule() as $item) {
            $this->data->file = file_get_contents(dirname(__DIR__, 3) . $this->path . $item);
            $newFile = str_replace([
                "Route",
                "Example",
                "examples"
            ], [
                ucfirst(strtolower($this->data->namespace)),
                ucfirst(strtolower($this->data->component)),
                (new Pluralize())->plural(strtolower($this->data->component))
            ], $item);
            if (str_contains($newFile, "app/Controller/")) {
                $dirPath = dirname(__DIR__, 2) . '/Controller/' . ucfirst(strtolower($this->data->namespace));
                if (!is_dir($dirPath) && !mkdir($dirPath, 0755) && !is_dir($dirPath)) {
                    throw new RuntimeException(sprintf('Directory "%s" was not created', $dirPath));
                }
            }
            if (str_contains($newFile, "routes/")) {
                $dirPath = dirname(__DIR__, 3) . '/routes/' . ucfirst(strtolower($this->data->namespace));
                if (!is_dir($dirPath) && !mkdir($dirPath, 0755) && !is_dir($dirPath)) {
                    throw new RuntimeException(sprintf('Directory "%s" was not created', $dirPath));
                }
            }
            $newFile = dirname(__DIR__, 3) .'/'. $newFile;
            file_put_contents($newFile, $this->replace());

        }
    }

    public function read()
    {

    }

    public function edit()
    {

    }

    public function destroy()
    {

    }

    private function replace()
    {
        return str_replace(
            ['Namespace', 'examples', 'Example', 'example'],
            [
                ucfirst(strtolower($this->data->namespace)),
                (new Pluralize())->plural(strtolower($this->data->component)),
                ucfirst(strtolower($this->data->component)),
                strtolower($this->data->component)
            ],
            $this->data->file
        );
    }

    private function pathFileErykiaModule(): array
    {
        $this->path = "/erykia/Module/";
        return [
            "app/Controller/Route/ExampleController.php",
            "app/Model/Example.php",
            "database/examples.php",
            "routes/Route/ExampleController.php"
        ];
    }
}