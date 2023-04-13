<?php

namespace Source\Controller\Module\ModuleTrait;

trait Store
{
    /**
     * @param $query
     * @return bool
     */
    public function store($query): bool
    {
        $this->setRequest($query);
        if (!$this->permission()) {
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }

        if(!$this->validate()){
            return false;
        }

        if (isset($this->data->category)) {
            $this->data->component .= "_category";
            $this->start();
        }
        $this->data->component = str_replace("_category", "", $this->data->component);
        $this->start();
        $this->setResponse(
            200,
            "success",
            $this->data->component . " created successfully",
            "module",
            dynamic: $this->data->component
        );

        echo $this->translate->translator($this->getResponse(), "message")->json();
        return true;
    }
}