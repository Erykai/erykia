<?php

namespace Source\Core;

use PDO;
use PDOException;
use stdClass;

/**
 * Controller
 */
class Controller
{
    use Auth;

    /**
     * @var object|null
     */
    protected ?object $argument;
    /**
     * @var string|null
     */
    protected ?string $columns = null;
    /**
     * @var PDO|String
     */
    protected PDO|string $conn;
    /**
     * @var object
     */
    protected object $response;
    /**
     * @var string|null
     */
    protected ?string $find;
    /**
     * @var bool
     */
    private bool $issetUpload = false;
    /**
     * @var int|null
     */
    protected ?int $offset;
    /**
     * @var string|null
     */
    protected ?string $order;
    /**
     * @var stdClass
     */
    protected stdClass $paginator;
    /**
     * @var array|null
     */
    protected ?array $params;
    /**
     * @var object|null
     */
    protected ?object $query;
    /**
     * @var Request
     */
    protected Request $request;
    /**
     * @var object
     */
    protected object $session;
    /**
     * @var Translate
     */
    protected Translate $translate;
    /**
     * @var Upload
     */
    protected Upload $upload;

    /**
     * Controller
     */
    public function __construct()
    {
        $this->session = new Session();
        $this->translate = new Translate();
        $this->setFind(null);
        $this->setParams(null);
    }
    //SYSTEM
    /**
     * @param string $dsn
     * @param string $host
     * @param string $base
     * @param string $username
     * @param string $password
     * @return String|PDO
     */
    protected function conn(string $dsn, string $host, string $base, string $username, string $password): PDO|string
    {
        if (empty($this->conn)) {
            try {
                $this->conn = new PDO(
                    $dsn . ":host=" . $host . ";dbname=" . $base,
                    $username,
                    $password,
                    [
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
                    ]
                );
            } catch (PDOException $e) {
                $this->conn = $e->getMessage();
            }
        }
        return $this->conn;
    }
    /**
     * @return bool
     */
    protected function permission(): bool
    {
        if (!$this->validateLogin()) {
            return false;
        }
        if (isset($this->data->level) && $this->data->level > $this->session->get()->login->level) {
            $this->setResponse(
                401,
                "error",
                "you do not have permission to make this edit -> user level min {$this->data->level}",
                "controller"
            );
            return false;
        }
        return true;
    }
    /**
     * @return string|null
     */
    public function getColumns(): ?string
    {
        return $this->columns;
    }
    /**
     */
    public function setColumns(): void
    {
        if (!empty($this->query->columns)) {
            $this->columns = $this->query->columns;
        }
    }
    //GET AND SET
    /**
     * @return object
     */
    protected function getResponse(): object
    {
        return $this->response;
    }
    /**
     * @param int $code
     * @param string $type
     * @param string $text
     * @param string $model
     * @param object|null $data
     * @param string|null $dynamic
     */
    protected function setResponse(int $code, string $type, string $text, string $model, ?object $data = null, ?string $dynamic = null): void
    {
        http_response_code($code);
        $this->response = (object)[
            "code" => $code,
            "type" => $type,
            "text" => $text,
            "model" => $model,
            "data" => $data,
            "dynamic" => $dynamic
        ];
    }
    /**
     * @return string|null
     */
    public function getFind(): ?string
    {
        return $this->find;
    }
    /**
     * @param string|null $find
     */
    public function setFind(?string $find): void
    {
        $this->find = $find;
    }
    /**
     * @return bool
     */
    public function isIssetUpload(): bool
    {
        return $this->issetUpload;
    }
    /**
     * @param bool $issetUpload
     */
    public function setIssetUpload(bool $issetUpload): void
    {
        $this->issetUpload = $issetUpload;
    }
    /**
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }
    /**
     * @param int|null $offset
     */
    public function setOffset(?int $offset): void
    {
        $this->offset = $offset;
    }
    /**
     * @return string|null
     */
    public function getOrder(): ?string
    {
        return $this->order;
    }
    /**
     * @return void
     */
    public function setOrder(): void
    {
        $order = null;
        if (!empty($this->query->sort)) {
            $sorts = explode(",", $this->query->sort);
            foreach ($sorts as $sort) {

                if (substr($sort, 0, 1) !== "-" && substr($sort, 0, 1) !== "+") {
                    $order .= $sort . " ASC, ";
                }

                if (substr($sort, 0, 1) === "-") {
                    $order .= substr($sort, 1) . " DESC, ";
                }
                if (substr($sort, 0, 1) === "+") {
                    $order .= substr($sort, 1) . " ASC, ";
                }
            }

            $order = trim($order);
            $order = substr($order, 0, -1);
        }
        $this->order = $order;
    }
    /**
     * @param int|null $all
     */
    protected function setPaginator(?int $all): void
    {
        if (isset($this->query)) {
            if (empty($this->query->per_page)) {
                $this->query->per_page = 100;
            }
            if ($this->query->per_page > 100) {
                $this->query->per_page = "100";
            }
            if ($this->query->per_page > $all) {
                $this->query->per_page = $all;
            }
            if (empty($this->query->page)) {
                $this->query->page = "1";
            }
            $this->paginator = new stdClass();
            $this->paginator->per_page = (int)$this->query->per_page;
            $this->paginator->page = (int)$this->query->page;
            $this->paginator->all_page = $all ? ceil($all / $this->query->per_page) : 0;
            $this->paginator->all = (int)$all;
            $offset = ($this->paginator->page > $this->paginator->all_page) ?
                $this->paginator->per_page * ($this->paginator->all_page - 1) :
                $this->paginator->per_page * ($this->paginator->page - 1);

            $this->setOffset($offset);
        }

    }
    /**
     * @return stdClass
     */
    protected function getPaginator(): stdClass
    {
        return $this->paginator;
    }
    /**
     * @return array|null
     */
    public function getParams(): ?array
    {
        return $this->params;
    }
    /**
     * @param array|null $params
     */
    public function setParams(?array $params): void
    {
        $this->params = $params;
    }
    /**
     * @param array|null $request
     */
    public function setRequest(?array $request): void
    {
        $this->request = new Request($request);
        $this->data = $this->request->response()->data->request;
        $this->query = $this->request->response()->data->query;
        if(isset($this->request->response()->data->query->columns)){
            $this->columns = $this->request->response()->data->query->columns;
        }
        if (empty($this->query)) {
            $this->query = new stdClass();
        }
        $this->argument = $this->request->response()->data->argument;
    }
    /**
     * @param string $search
     */
    protected function setSearch(string $search): void
    {
        $search = str_replace(["[", "]"], [""], $search);

        $search = explode(",", $search);
        if (count($search) > 0) {
            foreach ($search as $key => $value) {
                if (str_contains($value, "LIKE")) {
                    $return = explode("LIKE", $value);
                    $find[$key] = "$return[0] LIKE :$return[0]";
                    $params[$return[0]] = $return[1];
                    continue;
                }
                if (str_contains($value, "!=")) {
                    $return = explode("!=", $value);
                    $find[$key] = "$return[0] != :$return[0]";
                    $params[$return[0]] = $return[1];
                    continue;
                }
                if (str_contains($value, ">")) {
                    $return = explode(">", $value);
                    $find[$key] = "$return[0] > :$return[0]";
                    $params[$return[0]] = $return[1];
                    continue;
                }
                if (str_contains($value, "<")) {
                    $return = explode("<", $value);
                    $find[$key] = "$return[0] < :$return[0]";
                    $params[$return[0]] = $return[1];
                    continue;
                }
                if (str_contains($value, "=")) {
                    $return = explode("=", $value);
                    $find[$key] = "$return[0] = :$return[0]";
                    $params[$return[0]] = $return[1];
                }
            }
            if (isset($find, $params)) {
                $this->setFind(implode(" AND ", $find));
                $this->setParams(array_filter($params));
            }
        }
    }
}