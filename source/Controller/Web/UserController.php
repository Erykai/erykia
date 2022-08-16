<?php

namespace Source\Controller\Web;

use Source\Core\Auth;
use Source\Core\Controller;
use Source\Core\Request;
use Source\Core\Response;
use Source\Core\Upload;
use Source\Model\User;
use stdClass;

class UserController extends Controller
{
    use Auth;

    protected ?object $query;
    protected ?object $argument;

    public function store($query, string $response)
    {
        $this->request = new Request($query);
        $this->response = new Response();
        if ($this->request->response()->type === "error") {
            if ($response === 'json') {
                echo $this->response->data($this->request->response())->lang()->$response();
            } else {
                var_dump($this->response->data($this->request->response())->lang()->$response());
            }
            return false;
        }
        $this->user = $this->request->response()->data->request;
        $this->query = $this->request->response()->data->query;
        $this->argument = $this->request->response()->data->argument;

        $this->upload = new Upload();
        if ($this->upload->response()->type === "error") {
            if ($response === 'json') {
                echo $this->response->data($this->upload->response())->lang()->$response();
            } else {
                var_dump($this->response->data($this->upload->response())->lang()->$response());
            }
            return false;
        }

        $user = new User();
        $existUpload = false;
        if ($this->upload->save()) {
            foreach ($this->upload->response()->data as $key => $value) {
                //add FILES key as object
                //example $user->cover = 'storage/image/2022/08/10/image.jpg'
                //example $user->profile = 'storage/image/2022/08/10/profile.jpg'
                $user->$key = $value;
                $existUpload = true;
            }
        }
        foreach ($this->user as $key => $value) {
            $user->$key = $value;
        }

        if (!$user->save()) {
            if ($existUpload) {
                $this->upload->delete();
            }
            if ($response === 'json') {
                echo $this->response->data($user->response())->lang()->$response();
                return false;
            }
            var_dump($this->response->data($user->response())->lang()->$response());
            return false;
        }
        if ($response === 'json') {
            echo $this->response->data($user->response())->lang()->$response();
            return true;
        }
        var_dump($this->response->data($user->response())->lang()->$response());
        return true;
    }

    public function read($query, string $response)
    {
        $this->request = new Request($query);
        $this->response = new Response();

        $this->user = $this->request->response()->data->request;
        $this->query = $this->request->response()->data->query;
        if (empty($this->query)) {
            $this->query = new stdClass();
        }
        $this->argument = $this->request->response()->data->argument;
        $search = [];
        if (isset($this->query->search)) {
            $this->query->search = str_replace(["[", "]"], [""], $this->query->search);
            $search = explode(",", $this->query->search);
        }
        $find = null;
        $params = [];

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
            $find = implode(" AND ", $find);
            $params = array_filter($params);

        }

        $users = new User();
        $all = $users->find("id", $find, $params)->count();

        //paginator
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

        $paginator = new stdClass();
        $paginator->page = (int)$this->query->page;
        $paginator->per_page = (int)$this->query->per_page;
        $paginator->all_page = $all ? ceil($all / $this->query->per_page) : 0;
        $paginator->all = (int)$all;
        $offset = 0;
        //10 / 2 = 5 pages
        //define page 4 + per_pag 2
        if ($paginator->per_page !== $paginator->all) {
            $offset =  ($paginator->per_page * $paginator->page);
        }
        var_dump($offset);



        // all_page 3 / (page 2 / per_page 1)
        //page 1
        //per_page 1
        //all_page 3
        //all 3

        $user = $users->find("*", $find, $params)->order($order)->limit($this->query->per_page)->offset($offset)->fetch(true);

        if (!$user) {
            echo $this->response->data($users->response())->lang()->$response();
            return false;
        }

        $paginator->data = $user;

        echo $this->response->data($paginator)->$response();
        return true;
    }

    public function edit($query = null)
    {/*
        if (!$this->validateLogin()) {
            echo $this->getError();
            return false;
        }
        $this->user = $this->getData();
        $login = $this->session->get()->login;
        $users = (new \Source\Model\User());
        $user = $users->find('*', 'email=:email', ['email' => $login->email])->fetch();
        if(!$user){
            $this->setError(t("user does not exist"));
            echo $this->getError();
            return false;
        }
        foreach ($this->user as $key => $value) {
            if(
                ($key === 'email') &&
                (new \Source\Model\User())->find('id', 'email=:email', ['email' => $this->user->$key])->fetch() &&
                $this->user->$key !== $login->email
            ) {
                $this->setError(t("this email already exists"));
                echo $this->getError();
                return false;
            }
            if ($key === 'password') {
                $this->user->$key = password_hash($value, PASSWORD_BCRYPT, ['cost' => 12]);
            }
            $user->$key = $this->user->$key;
        }
        if(!$users->save()){
            $this->setError(t("error saving"));
            echo $this->getError();
            return false;
        }
      $this->session->destroy('login');
      $this->session->set('login', $user);
    */
    }

    public function destroy(array $data)
    {/*
        if(!isset($data[0])){
            $this->setError(t("you don't have this permission"));
            echo $this->getError();
            return false;
        }

        if (!$this->validateLogin()) {
            echo $this->getError();
            return false;
        }

        $login = $this->session->get()->login;
        $users = new \Source\Model\User();
        $user = $users->find('*', 'email=:email', ['email' => $login->email])->fetch();

        if(!$user){
            $this->setError(t("you don't have this permission"));
            echo $this->getError();
            return false;
        }
        if($user->id !== $data[0]['id']){
            $this->setError(t("you don't have this permission"));
            echo $this->getError();
            return false;
        }

        $users->delete($user->id);
   */
    }
}