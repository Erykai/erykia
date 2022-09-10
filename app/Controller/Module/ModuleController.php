<?php

namespace Source\Controller\Module;

use Source\Core\Controller;
use Source\Core\Module;
use Source\Core\Translate;
use stdClass;

/**
 * create news modules erykia
 */
class ModuleController extends Controller
{
    use Module;

    /**
     * @param $query
     * @return bool
     */
    public function store($query): bool
    {
        $this->setRequest($query);
        if (!$this->permission()) {
            echo $this->translate->translator($this->getError(), "message")->json();
            return false;
        }
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
        return true;
    }
}