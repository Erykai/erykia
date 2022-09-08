<?php

namespace Source\Model;

use Source\Core\Model;

class Example extends Model
{
    public function __construct()
    {
        parent::__construct(
            'examples',
            [
                'id_users',
                /*#####*/
            ]
        );
        $this->migration();
    }
}

