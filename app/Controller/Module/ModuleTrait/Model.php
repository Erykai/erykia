<?php

namespace Source\Controller\Module\ModuleTrait;

use RuntimeException;

trait Model
{

    protected function model(): void
    {
        $this->modelNotNull = [];
        if (str_contains($this->getComponent(), "Category")) {
            $data = $this->data->category;
        } else {
            $data = $this->data->database;
        }
        foreach ($data as $key => $column) {
            if (!isset($column->null)) {
                $this->modelNotNull[] = "'" . $key . "'";
            }
        }
        if (isset($this->modelNotNull)) {
            $model = implode("," . PHP_EOL . "                ", $this->modelNotNull);
            $file = str_replace('/*#####*/', $model, file_get_contents($this->getComponent()));

            $componentName = basename(str_replace('\\', '/', $this->component)); // Resultado: User
            if ($componentName === "User.php") {
                $save = 'public function save(): bool
    {
        if ($this->emailFilter() && $this->emailIsset() && $this->password()) {
            return parent::save();
        }
        return false;
    }';
                $file = str_replace('/*######*/', $save, $file);
            }

            if (file_put_contents($this->getComponent(), $file) === false) {
                throw new RuntimeException("error creating " . $this->getComponent());
            }
            unset($this->modelNotNull);
        }
    }
}