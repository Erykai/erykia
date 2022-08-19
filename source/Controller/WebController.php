<?php

namespace Source\Controller;


class WebController
{
    public function home(): bool
    {
        echo "home";
        return true;
    }

    public function about(): bool
    {
        echo "quem somos";
        return true;
    }

    public function news(): bool
    {
        echo "noticias";
        return true;
    }

    public function contact(): bool
    {
        echo "contato";
        return true;
    }
}