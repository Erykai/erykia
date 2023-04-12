<?php

namespace Source\Core;

use Erykai\Database\Database;
use Modules\User\Model\User;

/**
 *
 */
class Model extends Database
{
    /**
     * @return bool
     */
    protected function emailFilter(): bool
    {
        if (isset($this->email)) {
            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $dynamic = $this->email;
                $this->setResponse(
                    400,
                    "error",
                    "the email format $dynamic is invalid",
                    "email",
                    dynamic: $dynamic
                );
                return false;
            }
            return true;
        }
        return true;
    }

    /**
     * @return bool
     */
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
                        "email",
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
                        "email",
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

    /**
     * @return bool
     */
    protected function password(): bool
    {

        if (!empty($this->password)) {
            $this->password = password_hash($this->password, PASSWORD_BCRYPT, ['cost' => 12]);
            return true;
        }
        return true;
    }

    /**
     *
     */
    protected function migration(): void
    {

        $tableExists = $this->conn->query("SHOW TABLES LIKE '$this->table'")->rowCount() > 0;

        if (!$tableExists) {
            $namespace = get_class($this);
            $namespace = explode("\\",$namespace);
            if(file_exists(dirname(__DIR__, 2) . "/modules/" . $namespace[1] . "/Database/" . $this->table . ".php")){
                if(file_exists(dirname(__DIR__, 2) . "/modules/" . $namespace[1] . "Category/Database/" . $this->table . "_categories.php")){
                    $table = $this->table . "_categories";
                    $tableExistsCategories = $this->conn->query("SHOW TABLES LIKE '$table'")->rowCount() > 0;
                    if (!$tableExistsCategories) {
                        require_once dirname(__DIR__, 2) . "/modules/" . $namespace[1] . "Category/Database/" . $this->table . "_categories.php";
                    }
                }
                require_once dirname(__DIR__, 2) . "/modules/" . $namespace[1] . "/Database/" . $this->table . ".php";
            }
        }

    }

    /**
     * @param bool $all
     * @param string|null $getColumns
     * @param false $count
     * @return int|mixed
     */
    public function fetchReference(bool $all = false, ?string $getColumns = "", $count = false)
    {
        $columns = $this->conn->query("SHOW COLUMNS FROM $this->table")->fetchAll();
        $inner = null;
        $returnColumns = null;
        $relationships = Helper::relationship($columns, $this->table);

        /*
        if (!empty($getColumns)) {
            $getColumns = explode(",", $getColumns);
            $key = array_search("id", $getColumns);
            $issetId = false;
            if ($key !== false) {
                $getColumns[$key] = $this->table . '.id';
                $issetId = true;
            }
            if (!$issetId) {
                $getColumns[] = $this->table . '.id';
            }

            $key = array_search("name", $getColumns, true);

            if ($key) {
                $getColumns[$key] = $this->table . "." . $getColumns[$key];
            }
        }
        */

        if (!empty($getColumns)) {
            $getColumns = explode(",", $getColumns);
            foreach ($getColumns as $key => $Column) {
                $getColumns[$key] = $this->table . "." . $getColumns[$key];
            }

        }
        if (isset($relationships->relationship)) {
            foreach ($relationships->relationship as $key => $relationship) {
                if (isset($this->params)) {
                    $keyParam = array_search($relationship, array_keys($this->params), true);
                    if ($keyParam !== false) {
                        $params[] = $relationship . '.name';
                        $paramsReplace[] = " $relationship ";
                    }
                }
                if (!empty($getColumns)) {
                    $keyColumns = array_search($relationship, $getColumns, true);
                    if ($keyColumns !== false) {
                        $getColumns[$keyColumns] = $relationship . '.name' . " $relationship";
                    }
                }
                if ($relationship !== $this->table) {
                    $inner .= "INNER JOIN $relationship ON $this->table.$key = $relationship.id ";
                }
                $returnColumns .= "$relationship.name $relationship,";
            }

        }

        if (isset($relationships->tables)) {
            foreach ($relationships->tables as $key => $table) {
                // if ($key !== 'name') {
                $returnColumns .= $this->table . "." . "$key,";
                //   }

            }
            $returnColumns = substr($returnColumns, 0, -1);
        }
        $select = explode("SELECT", $this->query)[1];
        $columnsRequest = explode("FROM", $select)[0];

        if ($inner) {
            $comma = substr($returnColumns, -1);
            if ($comma === ",") {
                $returnColumns = substr($returnColumns, 0, -1);

            }
            $this->inner($inner);
        }
        if (!empty($getColumns)) {
            $getColumns = implode(",", $getColumns);
            $this->query = str_replace($columnsRequest, " $getColumns ", $this->query);
        } else if ($columnsRequest === " * ") {
            $this->query = str_replace("*", $returnColumns, $this->query);
        } else {
            $this->query = str_replace($returnColumns, " $columnsRequest ", $this->query);
        }

        $where = explode("WHERE", $this->query);
        if (isset($where[1])) {
            $whereColumns = explode("AND", $where[1]);
            foreach ($whereColumns as $key => $value) {
                if (isset($params[$key])) {
                    $returnParams[] = str_replace($paramsReplace[$key], " " . $params[$key] . " ", $value);

                } else {
                    $arrayColums = array_keys($this->params)[$key];
                    $returnParams[] = str_replace(" $arrayColums ", $this->table . '.' . array_keys($this->params)[$key] . " ", $value);
                }

            }
            $newQuery = implode("AND ", $returnParams);
            $newQuery = $where[0] . "WHERE " . $newQuery;
            $this->query = $newQuery;
        }

        if ($count) {
            return $this->count();
        }
        return $this->fetch($all);
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        return parent::save(); // TODO: Change the autogenerated stub
    }
}