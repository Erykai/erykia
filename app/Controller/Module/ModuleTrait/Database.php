<?php

namespace Source\Controller\Module\ModuleTrait;

use Source\Core\Helper;
use Source\Core\Pluralize;

trait Database
{
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
            $this->databaseCategories();
            unset($this->database);
        }

    }
    /**
     *
     */
    protected function databaseCategories(): void
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
}