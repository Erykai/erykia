<?php

namespace Source\Controller\Module;

use Source\Core\Controller;
use Source\Core\Pluralize;
use Source\Core\Translate;

/**
 * Class Resource
 * @package Source\Controller\Module
 */
abstract class Resource extends Controller
{
    /**
     * @var string
     */
    protected string $component;
    /**
     * @var array
     */
    protected array $database;
    
    /**
     * @var array
     */
    protected array $files;
    /**
     * @var array
     */
    protected array $modelNotNull;


    /**
     * start create module
     */
    protected function start(): void
    {
        if (!$this->validate()) {
            return;
        }
        foreach ($this->files(MODULE_PATH) as $file) {
            $fileType = $this->determineFileType($file);
            $this->create($file, $fileType);
        }
    }
    /**
     * @param $file
     * @param $fileType
     * @return void
     */
    protected function create($file, $fileType): void
    {
        $this->data->file = file_get_contents(MODULE_PATH . $file);

        $this->setComponent($file);
        $this->createDir();
        $this->setComponent(MODULE_PATH . $this->getComponent());
        file_put_contents($this->getComponent(), $this->replace());

        switch ($fileType) {
            case 'database':
                $this->database();
                break;
            case 'model':
                $this->model();
                break;
            case 'public':
                $this->public();
                break;
            default:
                // Nenhuma ação para tipos desconhecidos
                break;
        }
    }
    /**
     * @return array|string
     */
    protected function replace(): array|string
    {
        return $this->applyReplacements($this->data->file);
    }
    /**
     * @param string $file
     * @return void
     */
    protected function setComponent(string $file): void
    {
        $this->component = $this->applyReplacements($file);
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
     * @return string
     */
    protected function applyReplacements(string $file): string
    {
        $replacements = $this->getComponentReplacements();

        return str_replace(
            ['Namespace', 'examples', 'Example', 'example'],
            [
                $replacements['Namespace'],
                $replacements['examples'],
                $replacements['Example'],
                $replacements['example']
            ],
            $file
        );
    }
    /**
     * @return array
     */
    protected function getComponentReplacements(): array
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

        return [
            'Namespace' => $Namespace,
            'examples' => $examples,
            'Example' => $Example,
            'example' => $example
        ];
    }
    /**
     * @return bool
     */
    protected function validate(): bool
    {
        if (!isset($this->data->component, $this->data->database)) {
            $this->setResponse(401, "error", "component and database is mandatory", "module");
            echo Translate::getInstance()->translator($this->getResponse(), "message")->json();
            return false;
        }
        return true;
    }
}