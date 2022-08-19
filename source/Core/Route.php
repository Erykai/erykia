<?php

namespace Source\Core;

class Route extends \Erykai\Routes\Route{
    public function default(string $callback, string $controller, array $middleware = [false,false,false,false], $type = "json"): void
    {
        $this->get((new Translate())->router($callback),"$controller@read",$middleware[0], $type);
        $this->get((new Translate())->router($callback . '/{id}', "/{id}"),"$controller@read",$middleware[0],$type);
        $this->post((new Translate())->router($callback),"$controller@store",$middleware[1],$type);
        $this->put((new Translate())->router($callback . '/{id}', "/{id}"),"$controller@edit",$middleware[2],$type);
        $this->delete((new Translate())->router($callback . '/{id}', "/{id}"),"$controller@destroy",$middleware[3],$type);
    }

}