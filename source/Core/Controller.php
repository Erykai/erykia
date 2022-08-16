<?php

namespace Source\Core;

use stdClass;

/**
 * Controller
 */
class Controller
{
    /**
     * @var Request
     */
    protected Request $request;
    /**
     * @var Response
     */
    protected Response $response;
    /**
     * @var Upload
     */
    protected Upload $upload;
    /**
     * @var stdClass
     */
    protected stdClass $paginator;
    /**
     * @var object|null
     */
    protected ?object $query;
    /**
     * @var object|null
     */
    protected ?object $argument;
    /**
     * @var object|null
     */
    protected ?object $data;
    /**
     * @var object|Session
     */
    protected object $session;
    /**
     * @var object
     */
    private object $error;
    /**
     * @var string|null
     */
    protected ?string $find;
    /**
     * @var array|null
     */
    protected ?array $params;
    /**
     * @var int|null
     */
    protected ?int $offset;
    /**
     * @var string|null
     */
    protected ?string $order;
    /**
     * Controller
     */
    public function __construct()
    {
        $this->session = new Session();
        $this->response = new Response();
        $this->setFind(null);
        $this->setParams(null);
    }
    /**
     * @param int|null $all
     */
    protected function setPaginator(?int $all): void
    {
        if(isset($this->query)){
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
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }
    /**
     * @param array|null $request
     */
    public function setRequest(?array $request): void
    {
        $this->request = new Request($request);
        $this->data = $this->request->response()->data->request;
        $this->query = $this->request->response()->data->query;
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
                    continue;
                }
            }
            if(isset($find, $params)){
                $this->setFind(implode(" AND ", $find));
                $this->setParams(array_filter($params));
            }
        }
    }
    /**
     * @return object
     */
    protected function getError(): object
    {
        return $this->error;
    }

    /**
     * @param int $code
     * @param string $type
     * @param string $message
     * @param object|null $data
     * @param string|null $dynamic
     */
    protected function setError(int $code, string $type, string $message, ?object $data = null, ?string $dynamic = null): void
    {
        $this->error = (object)[
            "code" => $code,
            "type" => $type,
            "message" => $message,
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
}