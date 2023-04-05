<?php

namespace Source\Core;

class Route extends \Erykai\Routes\Route{
    public function default(string $callback, string $controller, array $middleware = [false,false,false,false], $type = "json", $translate = true, $path = null): void
    {
        if($translate){
            $translate = Translate::getInstance($path);
            $this->get($translate->router($callback),"$controller@read",$middleware[0], $type);
            $this->get($translate->router($callback . '/{id}', "/{id}"),"$controller@read",$middleware[0],$type);
            $this->post($translate->router($callback),"$controller@store",$middleware[1],$type);
            $this->post($translate->router($callback . '/{id}', "/{id}"),"$controller@edit",$middleware[2],$type);
            $this->put($translate->router($callback . '/{id}', "/{id}"),"$controller@edit",$middleware[2],$type);
            $this->delete($translate->router($callback . '/{id}', "/{id}"),"$controller@destroy",$middleware[3],$type);
        }else{
            $this->get($callback,"$controller@read",$middleware[0], $type);
            $this->get($callback . '/{id}',"$controller@read",$middleware[0],$type);
            $this->post($callback,"$controller@store",$middleware[1],$type);
            $this->post($callback . '/{id}',"$controller@edit",$middleware[2],$type);
            $this->put($callback . '/{id}',"$controller@edit",$middleware[2],$type);
            $this->delete($callback . '/{id}',"$controller@destroy",$middleware[3],$type);
        }

    }

}