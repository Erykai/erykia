<?php

namespace Source\Controller\Module\ModuleTrait;

use RuntimeException;
use Source\Core\Pluralize;
use stdClass;

trait PublicDashboard
{
    private string $all;
    private string $destroy;
    private string $edit;
    private string $read;
    private string $store;
    private string $trash;

    protected function public(): void
    {
        $this->allPublic();
        $this->readPublic();
        $this->storePublic();
        $this->editPublic();
    }

    protected function allPublic(): void
    {
        if (str_contains($this->getComponent(), "Category")) {
            foreach ($this->data->category as $key => $item) {
                $item->Field = $key;
                $data[] = $item;
            }
        } else {
            $data = $this->data->database;
        }
        $th = "";
        $datatable = '"id",';
        $i = 0;
        foreach ($data as $key => $item) {
            if (!isset($item->Field)) {
                $item->Field = $key;
            }
            if (
                !str_contains($item->Field, "id_") &&
                !str_contains($item->Field, "dad") &&
                !str_contains($item->Field, "cover") &&
                !str_contains($item->Field, "slug") &&
                !str_contains($item->Field, "created_at") &&
                !str_contains($item->Field, "updated_at")
            ) {
                $i++;
                if ($i <= 2) {
                    $th .= "<th>{{" . ucfirst($item->Field) . "}}</th>";
                    $datatable .= '"' . $item->Field . '",';
                }
            }
        }
        $datatable = substr($datatable, 0, -1);
        $datatable = '[' . $datatable . ']';
        $allTh = '/*#all-th#*/';
        $allDatable = '/*#all-datatable#*/';
        $file = str_replace($allTh, $th, file_get_contents($this->getComponent()));
        if (file_put_contents($this->getComponent(), $file) === false) {
            throw new RuntimeException("error creating " . $this->getComponent());
        }

        $file = str_replace($allDatable, $datatable, file_get_contents($this->getComponent()));
        if (file_put_contents($this->getComponent(), $file) === false) {
            throw new RuntimeException("error creating " . $this->getComponent());
        }
    }

    protected function readPublic(): void
    {
        $replace = '/*#read-li#*/';
        $this->populate($replace, "output", "li");

    }

    protected function storePublic(): void
    {
        $replace = '/*#store-input#*/';
        $this->populate($replace, "input");
    }

    protected function editPublic(): void
    {
        $replace = '/*#edit-input#*/';
        $this->populate($replace, "input");
    }

    private function populate($replace, $ioFolder, $ioFile = null): void
    {

        if (str_contains($this->getComponent(), "Category")) {
            foreach ($this->data->category as $key => $item) {
                $item->Field = $key;
                $data[] = $item;
                $component = $this->data->component;
            }
        } else {
            $data = $this->data->database;
            $component = $this->data->component;
        }
        $input = "";

        foreach ($data as $key => $item) {
            if (!isset($item->Field)) {
                $item->Field = $key;
            }
            if (!str_contains($item->Field, "cover")) {
                $Field = $item->Field;
                if (str_contains($item->Field, "id_")) {
                    $Field = str_replace("id_", "", $item->Field);
                }

                $labelField = str_replace("_", " ", $Field);
                $this->replace = new stdClass();
                $this->replace->label = ucfirst((new Pluralize())->singular($labelField));
                $this->replace->id = ucfirst($component) . ucfirst($Field);
                $this->replace->relation = '$this->' . $component . '->' . $item->Field;

                $this->replace->name = $item->Field;
                $this->replace->route = $Field;
                $this->replace->value = '$this->' . $component . '->' . $Field;

                if($ioFolder === "output" && $ioFile !== null){
                    $selectContent = file_get_contents(dirname(__DIR__, 1) . "/Component/".$ioFolder."/".$ioFile.".php");
                }else{
                    $selectContent = file_get_contents(dirname(__DIR__, 1) . "/Component/".$ioFolder."/".$item->input.".php");
                }


                foreach ($this->replace as $key => $value) {
                    $search = "\$this->replace->{$key}";
                    $selectContent = str_replace($search, $value, $selectContent);
                }

                $input .= $selectContent;
            }
        }

        $file = str_replace($replace, $input, file_get_contents($this->getComponent()));
        if (file_put_contents($this->getComponent(), $file) === false) {
            throw new RuntimeException("error creating " . $this->getComponent());
        }
    }



}