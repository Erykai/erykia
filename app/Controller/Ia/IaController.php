<?php

namespace Source\Controller\Ia;

use Source\Core\Controller;

class IaController extends Controller
{
    public function read(): void
    {
        require dirname(__DIR__, 3) . "/erykia/views/chat.html";
    }

    public function store(): void
    {
        $this->setRequest(null);
        if(!isset($this->session->get()->name))
        {
            $this->session->set('name', $this->data->name);
        }
        echo $this->session->get()->name;
    }

    public function edit(): void
    {
        echo "editar";
    }

    public function destroy(): void
    {
        echo "deletar";
    }
}