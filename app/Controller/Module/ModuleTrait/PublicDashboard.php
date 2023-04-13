<?php

namespace Source\Controller\Module\ModuleTrait;

use RuntimeException;
use Source\Core\Pluralize;

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
            if(!isset($item->Field)){
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
        $li = "";
        foreach ($data as $key =>$item) {

            if(!isset($item->Field)){
                $item->Field = $key;
            }
            if(str_contains($item->Field, "id_")) {
                $Field = str_replace("id_", "", $item->Field);
                $labelField = str_replace("_", " ", $Field);
                $li .= '<li class="list-group-item"><b>{{' . ucfirst((new Pluralize())->singular($labelField)) . '}}:</b> {{ $this->' . $component . '->' . $Field . ' }}</li>';
            }else{
                $li .= '<li class="list-group-item"><b>{{' . ucfirst(str_replace("_", " ", (new Pluralize())->singular($item->Field))) . '}}:</b> {{ $this->' . $component . '->' . $item->Field . ' }}</li>';
            }

        }
        $readLi = '/*#read-li#*/';
        $file = str_replace($readLi, $li, file_get_contents($this->getComponent()));
        if (file_put_contents($this->getComponent(), $file) === false) {
            throw new RuntimeException("error creating " . $this->getComponent());
        }
    }

    protected function storePublic(): void
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
            if(!isset($item->Field)){
                $item->Field = $key;
            }
            if (!str_contains($item->Field, "cover")) {
                if(str_contains($item->Field, "id_")){
                    $Field = str_replace("id_", "", $item->Field);
                    $labelField = str_replace("_", " ", $Field);
                    $input .= '<div class="mb-3">
                             <label class="small mb-1" for="input' . ucfirst($component) . ucfirst($Field) . '">{{' . ucfirst($labelField) . '}}</label>
                            <select 
                            class="form-control select2-field" 
                            name="' . $item->Field . '" 
                            id="input' . ucfirst($component) . ucfirst($Field) . '" 
                            data-search-endpoint="{{#/'.$Field.'#}}"></select>
                        </div>';
                }else{
                    $input .= '<div class="mb-3">
                              <label 
                              class="small mb-1" 
                              for="input' . ucfirst($component) . ucfirst($item->Field) . '">{{' . ucfirst($item->Field) . '}}
                              </label>
                              <input 
                              name="' . $item->Field . '" 
                              class="form-control" 
                              id="input' . ucfirst($component) . ucfirst($item->Field) . '" 
                              type="text"
                              placeholder="{{' . ucfirst($item->Field) . '}}"/>
                        </div>';
                }

            }

        }
        $readInput = '/*#store-input#*/';
        $file = str_replace($readInput, $input, file_get_contents($this->getComponent()));
        if (file_put_contents($this->getComponent(), $file) === false) {
            throw new RuntimeException("error creating " . $this->getComponent());
        }
    }

    protected function editPublic(): void
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
            if(!isset($item->Field)){
                $item->Field = $key;
            }
            if (!str_contains($item->Field, "cover")) {
                if(str_contains($item->Field, "id_")){
                    $Field = str_replace("id_", "", $item->Field);
                    $labelField = str_replace("_", " ", $Field);
                    $input .= '<div class="mb-3">
                             <label class="small mb-1" for="input' . ucfirst($component) . ucfirst($Field) . '">{{' . ucfirst((new Pluralize())->singular($labelField)) . '}}</label>
                            <select 
                            class="form-control select2-field" 
                            name="' . $item->Field . '" 
                            id="input' . ucfirst($component) . ucfirst($Field) . '" 
                            data-search-endpoint="{{#/'.$Field.'#}}"
                            data-selected-id="{{ $this->'.$component.'->'.$item->Field.' }}"
                            ></select>
                        </div>';
                }else{
                    $input .= '<div class="mb-3">
                              <label 
                              class="small mb-1" 
                              for="input' . ucfirst($component) . ucfirst($item->Field) . '">{{' . ucfirst(str_replace("_", " ", $item->Field)) . '}}
                              </label>
                              <input 
                              name="' . $item->Field . '" 
                              class="form-control" 
                              id="input' . ucfirst($component) . ucfirst($item->Field) . '" 
                              type="text"
                              placeholder="{{' . ucfirst($item->Field) . '}}"
                              value="{{ $this->'.$component.'->'.$item->Field.' }}"
                              />
                        </div>';
                }

            }

        }
        $readInput = '/*#edit-input#*/';
        $file = str_replace($readInput, $input, file_get_contents($this->getComponent()));
        if (file_put_contents($this->getComponent(), $file) === false) {
            throw new RuntimeException("error creating " . $this->getComponent());
        }
//
//        if (str_contains($this->getComponent(), "Category")) {
//            foreach ($this->data->category as $key => $item) {
//                $item->Field = $key;
//                $data[] = $item;
//                $component = $this->data->component;
//            }
//        } else {
//            $data = $this->data->database;
//            $component = $this->data->component;
//        }
//        $input = "";
//        foreach ($data as $key => $item) {
//            if(!isset($item->Field)){
//                $item->Field = $key;
//            }
//            if (!str_contains($item->Field, "cover")) {
//                $input .= '<div class="mb-3">
//                              <label
//                              class="small mb-1"
//                              for="input{{' . $component . ucfirst($item->Field) . '}}">{{' . ucfirst($item->Field) . '}}
//                              </label>
//                              <input
//                              name="' . $item->Field . '"
//                              class="form-control"
//                              id="input{{' . $component . ucfirst($item->Field) . '}}"
//                              type="text"
//                              placeholder="{{' . ucfirst($item->Field) . '}}" value="{{ $this->'.$component.'->'.$item->Field.' }}"/>
//                        </div>';
//            }
//
//        }
//        $editInput = '/*#edit-input#*/';
//        $file = str_replace($editInput, $input, file_get_contents($this->getComponent()));
//        if (file_put_contents($this->getComponent(), $file) === false) {
//            throw new RuntimeException("error creating " . $this->getComponent());
//        }
    }
}