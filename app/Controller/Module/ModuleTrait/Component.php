<?php

namespace Source\Controller\Module\ModuleTrait;

use RuntimeException;
use Source\Core\Pluralize;
use stdClass;

/**
 * Class Component
 * @package Source\Controller\Module\ModuleTrait
 */
trait Component
{
    /**
     * @return void
     */
    protected function component(): void
    {
        $this->readAllComponent();
        $this->readComponent();
        $this->storeComponent();
        $this->editComponent();
    }

    /**
     * @return void
     */
    protected function readAllComponent(): void
    {
        $th = "";
        $datatable = '"id",';
        $i = 0;
        foreach ($this->dataComponent() as $key => $item) {
            $item = $this->ensureFieldIsSet($item, $key);
            if ($this->isValidField($item->Field)) {
                $i++;
                if ($i <= 2) {
                    $th .= "<th>{{" . ucfirst(str_replace(["id_", "_"], [""," "], $item->Field)) . "}}</th>";
                    $datatable .= '"' . str_replace("id_", "", $item->Field) . '",';
                }
            }
        }
        $datatable = '[' . rtrim($datatable, ',') . ']';
        $this->replaceComponent('/*#all-th#*/', $th);
        $this->replaceComponent('/*#all-datatable#*/', $datatable);
    }

    /**
     * @return void
     */
    protected function readComponent(): void
    {
        $this->populate('/*#read-li#*/', "output", "li");
    }

    /**
     * @return void
     */
    protected function storeComponent(): void
    {
        $this->populate('/*#store-input#*/', "input");
    }

    /**
     * @return void
     */
    protected function editComponent(): void
    {
        $this->populate('/*#edit-input#*/', "input");
    }

    /**
     * @param string $replace
     * @param string $ioFolder
     * @param string|null $ioFile
     * @return void
     */
    private function populate(string $replace, string $ioFolder, string $ioFile = null): void
    {
        $input = "";

        foreach ($this->dataComponent() as $key => $item) {
            $item = $this->ensureFieldIsSet($item, $key);
            if (!str_contains($item->Field, "cover")) {
                $this->populateInput($item, $ioFolder, $ioFile, $input);
            }
        }
        $this->replaceComponent($replace, $input);
    }

    /**
     * @param stdClass $item
     * @param string $key
     * @return stdClass
     */
    private function ensureFieldIsSet(stdClass $item, string $key): stdClass
    {
        if (!isset($item->Field)) {
            $item->Field = $key;
        }
        return $item;
    }

    /**
     * @param string $field
     * @return bool
     */
    private function isValidField(string $field): bool
    {
        $invalidFields = [
            "dad", "cover", "slug", "created_at", "updated_at"
        ];

        foreach ($invalidFields as $invalidField) {
            if (str_contains($field, $invalidField)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param stdClass $item
     * @param string $ioFolder
     * @param string|null $ioFile
     * @param string $input
     * @return void
     */
    private function populateInput(stdClass $item, string $ioFolder, ?string $ioFile, string &$input): void
    {
        $Field = $this->processFieldName($item->Field);
        $labelField = str_replace("_", " ", $Field);
        $this->initializeReplace($labelField, $Field, $item->Field);

        if ($ioFolder === "output" && $ioFile !== null) {
            $selectContent = file_get_contents(dirname(__DIR__, 1) . "/Component/" . $ioFolder . "/" . $ioFile . ".php");
        } else {
            $selectContent = file_get_contents(dirname(__DIR__, 1) . "/Component/" . $ioFolder . "/" . $item->input . ".php");
        }

        foreach ($this->replace as $keyR => $value) {
            $search = "\$this->replace->$keyR";
            $selectContent = str_replace($search, $value, $selectContent);
        }

        $input .= $selectContent;
    }

    /**
     * @param string $field
     * @return string
     */
    private function processFieldName(string $field): string
    {
        if (str_contains($field, "id_")) {
            return str_replace("id_", "", $field);
        }
        return $field;
    }

    /**
     * @param string $labelField
     * @param string $Field
     * @param string $itemField
     * @return void
     */
    private function initializeReplace(string $labelField, string $Field, string $itemField): void
    {
        $this->replace = new stdClass();
        $this->replace->label = ucfirst((new Pluralize())->singular($labelField));
        $this->replace->id = ucfirst($this->data->component) . ucfirst($Field);
        $this->replace->relation = '$this->' . $this->data->component . '->' . $itemField;
        $this->replace->name = $itemField;
        $this->replace->route = $Field;
        $this->replace->value = '$this->' . $this->data->component . '->' . $Field;
    }

    /**
     * @param string $search
     * @param string $replace
     * @return void
     */
    private function replaceComponent(string $search, string $replace): void
    {
        $file = str_replace($search, $replace, file_get_contents($this->getComponent()));
        if (file_put_contents($this->getComponent(), $file) === false) {
            throw new RuntimeException("error creating " . $this->getComponent());
        }
    }

    /**
     * @return object
     */
    private function dataComponent(): object
    {
        if (str_contains($this->getComponent(), "Category")) {
            $data = $this->data->category;
        } else {
            $data = $this->data->database;
        }
        return $data;
    }

}