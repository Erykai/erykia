<?php

namespace Source\Core;

use Erykai\Database\Database;
use Source\Model\User;

class Model extends Database
{
    protected function emailFilter(): bool
    {
        if (isset($this->email)) {
            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $dynamic = $this->email;
                $this->setResponse(
                    400,
                    "error",
                    "the email format $dynamic is invalid",
                    dynamic: $dynamic
                );
                return false;
            }
            return true;
        }
        return true;
    }

    protected function emailIsset(): bool
    {
        if (isset($this->email)) {
            $users = new User();
            $user = $users->find('id', 'email=:email', ['email' => $this->email])->fetch();
            if ($user) {
                if (!isset($this->id)) {
                    $dynamic = $this->email;
                    $this->setResponse(
                        400,
                        "error",
                        "the email $dynamic already exists",
                        dynamic: $dynamic
                    );
                    return false;
                }
                if ($this->id !== $user->id) {
                    $dynamic = $this->email;
                    $this->setResponse(
                        400,
                        "error",
                        "the email $dynamic already exists in another account",
                        dynamic: $dynamic
                    );

                    return false;
                }
                return true;
            }
            return true;
        }
        return true;
    }

    protected function password(): bool
    {

        if (!empty($this->password)) {
            $this->password = password_hash($this->password, PASSWORD_BCRYPT, ['cost' => 12]);
            return true;
        }
        return true;
    }

    protected function migration(): void
    {
        $tableExists = $this->conn->query("SHOW TABLES LIKE '$this->table'")->rowCount() > 0;
        if (!$tableExists) {
            require_once dirname(__DIR__, 2) . "/database/" . $this->table . ".php";
        }

    }

    public function fetchReference(bool $all = false, ?string $getColumn = "", $count = false): object|int|null
    {
        if (!empty($getColumn)) {
            $getColumns = explode(",", $getColumn);
            $key = array_search("id", $getColumns);
            $issetId = false;
            if ($key !== false) {
                $getColumns[$key] = $this->table . '.id';
                $issetId = true;
            }
            if (!$issetId) {
                $getColumns[] = $this->table . '.id';
            }
        }
        $columns = $this->conn->query("SHOW COLUMNS FROM $this->table")->fetchAll();
        $inner = null;
        $returnColumns = null;

        foreach ($columns as $column) {
            if ((strpos($column->Field, "id_")) !== false) {
                $table = str_replace("id_", "", $column->Field);
                if (isset($this->params)) {
                    $keyParam = array_search($table, array_keys($this->params), true);
                    if ($keyParam !== false) {
                        $params[] = $table . '.name';
                        $paramsReplace[] = " $table ";
                    }
                }
                if (!empty($getColumns)) {
                    $key = array_search($table, $getColumns, true);
                    if ($key !== false) {
                        $getColumns[$key] = $table . '.name' . " $table";
                    }
                }
                if($table !== $this->table){
                    $inner .= "INNER JOIN $table ON $this->table.$column->Field = $table.id ";
                }

                $returnColumns .= "$table.name $table,";
            } else {
                $returnColumns .= "$this->table.$column->Field,";
            }
        }

        $select = explode("SELECT", $this->query)[1];
        $columnsRequest = explode("FROM", $select)[0];

        if ($inner) {
            $returnColumns = substr($returnColumns, 0, -1);
            $this->inner($inner);
            if(isset($getColumns)){
                $this->defineQuery($getColumns, $columnsRequest, $returnColumns);
            }

        }else if(isset($getColumns)){
            $this->defineQuery($getColumns, $columnsRequest, $returnColumns);
        }

        $where = explode("WHERE", $this->query);
        if (isset($where[1])) {
            $whereColumns = explode("AND", $where[1]);
            foreach ($whereColumns as $key => $value) {
                if(isset($params[$key])){
                    if(isset($paramsReplace)){
                        $returnParams[] = str_replace($paramsReplace[$key], " " . $params[$key] . " ", $value);
                    }
                }else{
                    $arrayColumns = array_keys($this->params)[$key];
                    $returnParams[] = str_replace(" $arrayColumns ", $this->table.'.'.array_keys($this->params)[$key], $value);
                }

            }
            if(isset($returnParams)){
                $newQuery = implode("AND ", $returnParams);
                $newQuery = $where[0] ."WHERE". $newQuery;
                $this->query = $newQuery;
            }

        }
        if ($count) {
            return $this->count();
        }
        return $this->fetch($all);
    }

    public
    function save(): bool
    {
        return parent::save(); // TODO: Change the autogenerated stub
    }

    /**
     * @param array $getColumns
     * @param string $columnsRequest
     * @param string $returnColumns
     */
    private function defineQuery(array $getColumns, string $columnsRequest, string $returnColumns): void
    {
        if (!empty($getColumns)) {
            $this->query = str_replace($columnsRequest, " $getColumns ", $this->query);
        } else if ($columnsRequest === " * ") {
            $this->query = str_replace("*", $returnColumns, $this->query);
        } else {
            $this->query = str_replace($returnColumns, " $columnsRequest ", $this->query);
        }
    }
}