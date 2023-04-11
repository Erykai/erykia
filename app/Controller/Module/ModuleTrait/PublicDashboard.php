<?php

namespace Source\Controller\Module\ModuleTrait;

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
      //  var_dump($this);
    }
}