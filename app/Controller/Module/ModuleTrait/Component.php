<?php

namespace Source\Controller\Module\ModuleTrait;

use RuntimeException;
use Source\Core\Pluralize;
use stdClass;

trait Component
{
    protected function component(): void
    {
        $this->allComponent();
        $this->readComponent();
        $this->storeComponent();
        $this->editComponent();
    }

    protected function allComponent(): void
    {
        $th = "";
        $datatable = '"id",';
        $i = 0;
        foreach ($this->dataComponent() as $key => $item) {
            $item = $this->ensureFieldIsSet($item, $key);
            if ($this->isValidField($item->Field)) {
                $i++;
                if ($i <= 2) {
                    $th .= "<th>{{" . ucfirst($item->Field) . "}}</th>";
                    $datatable .= '"' . $item->Field . '",';
                }
            }
        }
        $datatable = '[' . rtrim($datatable, ',') . ']';
        $this->replaceComponent('/*#all-th#*/', $th);
        $this->replaceComponent('/*#all-datatable#*/', $datatable);
    }

    protected function readComponent(): void
    {
        $this->populate('/*#read-li#*/', "output", "li");
    }

    protected function storeComponent(): void
    {
        $this->populate('/*#store-input#*/', "input");
    }

    protected function editComponent(): void
    {
        $this->populate('/*#edit-input#*/', "input");
    }

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

    private function ensureFieldIsSet(stdClass $item, string $key): stdClass
    {
        if (!isset($item->Field)) {
            $item->Field = $key;
        }
        return $item;
    }

    private function isValidField(string $field): bool
    {
        $invalidFields = [
            "id_", "dad", "cover", "slug", "created_at", "updated_at"
        ];

        foreach ($invalidFields as $invalidField) {
            if (str_contains($field, $invalidField)) {
                return false;
            }
        }

        return true;
    }

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

    private function processFieldName(string $field): string
    {
        if (str_contains($field, "id_")) {
            return str_replace("id_", "", $field);
        }
        return $field;
    }

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

    private function replaceComponent(string $search, string $replace): void
    {
        $file = str_replace($search, $replace, file_get_contents($this->getComponent()));
        if (file_put_contents($this->getComponent(), $file) === false) {
            throw new RuntimeException("error creating " . $this->getComponent());
        }
    }

    private function dataComponent(): array|object
    {
        $data = [];
        if (str_contains($this->getComponent(), "Category")) {
            foreach ($this->data->category as $item) {
                $data[] = $item;
            }
        } else {
            $data = $this->data->database;
        }
        return $data;
    }

}