<?php

namespace Source\Core;

use Erykai\Database\Database;

class Model extends Database
{
    public function __construct(string $table, array $notNull, string $id = 'id')
    {
        parent::__construct($table, $notNull, $id);
    }
}