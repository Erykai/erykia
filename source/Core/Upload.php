<?php

namespace Source\Core;

class Upload
{
    public function image($files)
    {
        return "/storage/image/2022/07/29/$files->input.jpg";
    }
}