<?php

namespace Source\Model;

use Source\Core\Model;

class User extends Model
{
    public function __construct()
    {
        parent::__construct(
            'users',
            [
                'name',
                'email',
                'password',
                'level'
            ]
        );
    }
}