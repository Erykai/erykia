<?php

namespace Modules\Example\Model;

use Source\Core\Model;

class Example extends Model
{
    public function __construct()
    {
        parent::__construct(
            'examples',
            [
                'id_examples',
                'trash',
                /*#####*/
            ]
        );
        $this->migration();
    }
    /*######*/
}