<?php

namespace Modules\User\Model;

use Source\Core\Model;

class User extends Model
{
    public function __construct()
    {
        parent::__construct(
            'users',
            [
                'id_users',
                'trash',
                'name',
                'email',
                'password',
                'level'
            ]
        );
        $this->migration();
    }
    public function save(): bool
    {
        if ($this->emailFilter() && $this->emailIsset() && $this->password()) {
            return parent::save();
        }
        return false;
    }
}