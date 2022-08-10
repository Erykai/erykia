<?php

namespace Source\Core;

class Route extends \Erykai\Routes\Route{

    public function default(string $callback, string $response, array $middleware): void
    {
        $this->get($callback,"$response@read",$middleware[0]);
        $this->get("$callback/{id}","$response@read",$middleware[0]);
        $this->post($callback,"$response@store",$middleware[1]);
        $this->put("$callback/{id}","$response@edit",$middleware[2]);
        $this->delete("$callback/{id}","$response@destroy",$middleware[3]);
    }
}