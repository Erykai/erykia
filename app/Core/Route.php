<?php

namespace Source\Core;

class Route extends \Erykai\Routes\Route{
    public function default(string $callback, string $controller, array $middleware = [false,false,false,false], $type = "json", $translate = true): void
    {
        if($translate){
            $this->get((new Translate())->router($callback),"$controller@read",$middleware[0], $type);
            $this->get((new Translate())->router($callback . '/{id}', "/{id}"),"$controller@read",$middleware[0],$type);
            $this->post((new Translate())->router($callback),"$controller@store",$middleware[1],$type);
            $this->put((new Translate())->router($callback . '/{id}', "/{id}"),"$controller@edit",$middleware[2],$type);
            $this->delete((new Translate())->router($callback . '/{id}', "/{id}"),"$controller@destroy",$middleware[3],$type);
        }else{
            $this->get($callback,"$controller@read",$middleware[0], $type);
            $this->get($callback . '/{id}',"$controller@read",$middleware[0],$type);
            $this->post($callback,"$controller@store",$middleware[1],$type);
            $this->put($callback . '/{id}',"$controller@edit",$middleware[2],$type);
            $this->delete($callback . '/{id}',"$controller@destroy",$middleware[3],$type);
        }

    }

}