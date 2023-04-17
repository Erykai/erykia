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
            $column->default = null;
            if(isset($column->schema->type)){
                $column->type = $column->schema->type;
            }
            if(isset($column->schema->default)){
                $column->default = $column->schema->default;
            }
            $this->database[] = '$migration->column("' . $key . '")->type("' . $column->type . '")->default('.$column->default.')' . (isset($column->null) ? '->null()' : '') . ';';
            if (!isset($column->null)) {
                $this->modelNotNull[] = "'" . $key . "',";
            }
        }
        $database = implode(PHP_EOL, $this->database);
        $file = str_replace('/*###*/', $database, file_get_contents($this->getComponent()));
        file_put_contents($this->getComponent(), $file);
        foreach ($data as $key => $column) {
            if (str_contains($key, 'id_')) {
                unset($this->database);
                $this->addKeyRelations();
            }
        }
        if (!empty($this->data->category)) {
            unset($this->database);
        }

    }

    protected function addKeyRelations(): void
    {
        $relationships = Helper::relationship((array)$this->data->database, $this->data->component);
        if (isset($relationships->relationship)) {
            foreach ($relationships->relationship as $key => $relationship) {
                $this->database[] = '$migration->addKey("' . (new Pluralize())->plural(strtolower($this->data->component)) . '_' . $relationship . '", "' . $key . '", "' . $relationship . '", "id");';
            }
            $database = implode(PHP_EOL, $this->database);
            $file = str_replace('/*####*/', $database, file_get_contents($this->getComponent()));
            file_put_contents($this->getComponent(), $file);
        }


    }
}