<?php

namespace Source\Model;

use Source\Core\Model;

class PostCategory extends Model
{
    public function __construct()
    {
        parent::__construct(
            'posts_categories',
            [
                'id_user',
                'title'
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
            return parent::save(); // TODO: Change the autogenerated stub
    }
}