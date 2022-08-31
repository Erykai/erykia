<?php

namespace Source\Model;

use Source\Core\Model;

/**
 * @property mixed $id_user
 * @property mixed|string $dad
 * @property mixed|string $created_at
 * @property mixed|string $updated_at
 */
class User extends Model
{
    public function __construct()
    {
        parent::__construct(
            'users',
            [
                'id_user',
                'dad',
                'name',
                'email',
                'password',
                'level'
            ]
        );
        $this->migration();

    }

    public function migration(): void
    {
        $tableExists = $this->conn->query("SHOW TABLES LIKE '$this->table'")->rowCount() > 0;
        if (!$tableExists) {
            require_once dirname(__DIR__, 2) . "/database/" . $this->table . ".php";
        }
    }

    public function save(): bool
    {
        if ($this->emailFilter() && $this->emailIsset() && $this->password()) {
            return parent::save(); // TODO: Change the autogenerated stub
        }
        return false;
    }
}