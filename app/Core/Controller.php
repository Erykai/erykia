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
    protected Template $template;
    public ?string $menu;
    /**
     * Controller
     */
    public function __construct(
        $template = TEMPLATE_DASHBOARD,
        $themeIndex = "public/".TEMPLATE_DASHBOARD,
        $themePage = "public/".TEMPLATE_DASHBOARD,
        $ext = "php"
    )
    {
        $this->session = new Session();
        $this->translate = Translate::getInstance();
        $this->setFind(null);
        $this->setParams(null);
        $this->setMenu($template);
        $this->template = new Template($themeIndex,$themePage,$ext, $this->menu);
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
        if (isset($this->request->response()->data->query->columns)) {
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
    protected function setSearch(string $search, string $OrAnd = "AND"): void
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
            //var_dump($find, $params);
            if (isset($find, $params)) {
                $this->setFind(implode(" ".$OrAnd." ", $find));
                $this->setParams(array_filter($params));
            }
        }
    }

    public function setUpload($object)
    {
        $this->upload = new Upload();

        if (isset($this->data->cover)) {
            if (filter_var($this->data->cover, FILTER_VALIDATE_URL)) {
                $this->upload = new Upload($this->data->cover, "cover");
                unset($this->data->cover);
            }
        }


        if ($this->upload->save()) {
            if ($this->upload->response()->type === "error") {
                echo $this->translate->translator($this->upload->response(), "message")->$response();
                return false;
            }
            foreach ($this->upload->response()->data as $key => $value) {
                $object->$key = $value;
                $this->setIssetUpload(true);
            }
        }
        return true;
    }

    protected function setMenu($template)
    {
        $module_directories = glob(dirname(__DIR__, 2) . '/modules/*', GLOB_ONLYDIR);
        $this->menu = "";
        $module_directories = array_filter($module_directories, static function($value) {
            return !str_contains($value, 'Example');
        });

        foreach ($module_directories as $directory) {
            $menu_file = $directory . '/Public/'.$template.'/menu.php';
            if (file_exists($menu_file)) {
                $this->menu .= file_get_contents($menu_file);
            }
        }
    }

    /**
     * php interpreter for string template
     */
    protected function render(string $content): string
    {
        // Processes variable substitutions.
        $content = preg_replace_callback('/\{\{((?:\s*\$this->)?\$?[a-zA-Z_][a-zA-Z0-9_]*(?:->\$?[a-zA-Z_][a-zA-Z0-9_]*)*)\s*\}\}/', function ($matches) {
            if (strpos($matches[1], '$') !== false) {
                return '<?php echo isset(' . $matches[1] . ') ? ' . $matches[1] . ' : ""; ?>';
            } else {
                return '<?php echo isset($this->' . $matches[1] . ') ? $this->' . $matches[1] . ' : ""; ?>';
            }
        }, $content);
        // Create a unique temporary file name.
        $tempFile = tempnam(sys_get_temp_dir(), 'template_');
        // Write the template content to the temporary file.
        file_put_contents($tempFile, $content);
        // Capture the output generated by including the temp file.
        ob_start();
        extract(get_object_vars($this));
        include $tempFile;
        $output = ob_get_clean();
        // Remove the temp file.
        unlink($tempFile);
        return $output;
    }

    protected function datatable(array $query): array
    {
        $columns = "";
        $search = "";
        $per_page = $query['length'];
        $page = $query['start'];
        $sort = ($query['order'][0]['dir'] === 'asc' ? "+" : "-") . ($query['order'][0]['column'] !== '0' ? $query['order'][0]['column'] : 'id');
        foreach ($query['columns'] as $column) {
            if($column['data'] !== ''){
                $columns .= $column['data'] . ",";
                if(is_string($query['search']) && $column['searchable'] === 'true'){
                    $search .= $column['data'] . "LIKE%" . $query['search'] . "%,";
                }
            }
        }
        $search = substr($search, 0, -1);
        $columns = substr($columns, 0, -1);

        $this->setSearch($search, "OR");

        return [
            'page' => $page,
            'per_page' => $per_page,
            'columns' => $columns,
            'sort' => $sort
        ];
    }

    protected function loginPermission(){

        if (!$this->permission()) {
            $this->template = new Template("public/".TEMPLATE_DASHBOARD,"public/".TEMPLATE_DASHBOARD,"php");
            $this->template->nav("login","pages/login");
            $content = $this->template->getIndex();
            echo $this->render($content);
            return false;
        }
        if (empty($this->login->cover)) {
            $this->login->cover = "public/".TEMPLATE_DASHBOARD."/assets/img/illustrations/profiles/profile-1.png";
        }
        return true;
    }

}