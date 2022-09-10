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
     * @var string
     */
    private string $path;
    /**
     * @var string
     */
    private string $component;
    /**
     * @var array
     */
    private array $modelNotNull;
    /**
     * @var array
     */
    private array $database;

    /**
     * @param $query
     */
    public function store($query): void
    {
        $this->setRequest($query);
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
    }
}