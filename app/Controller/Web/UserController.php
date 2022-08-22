<?php

namespace Source\Controller\Web;

use Source\Core\Auth;
use Source\Core\Controller;
use Source\Core\Upload;
use Source\Model\User;

class UserController extends Controller
{
    use Auth;

    public function store($query, string $response): bool
    {
        $this->setRequest($query);

        if((new User())->find('id')->fetch() && !$this->permission()) {
            echo $this->translate->translator($this->getError(), "message")->json();
            return false;
        }

        if ($this->request->response()->type === "error") {
            if ($response === 'json') {
                echo $this->translate->translator($this->request->response(), "message")->$response();
            } else {
                var_dump($this->translate->translator($this->request->response(), "message")->$response());
            }
            return false;
        }

        $this->upload = new Upload();
        if ($this->upload->response()->type === "error") {
            if ($response === 'json') {
                echo $this->translate->translator($this->upload->response(), "message")->$response();
            } else {
                var_dump($this->translate->translator($this->upload->response(), "message")->$response());
            }
            return false;
        }

        $user = new User();
        $existUpload = false;
        if ($this->upload->save()) {
            foreach ($this->upload->response()->data as $key => $value) {
                $user->$key = $value;
                $existUpload = true;
            }
        }
        foreach ($this->data as $key => $value) {
            $user->$key = $value;
        }
        if ($this->validateLogin()) {
            $id = (int)$this->session->get()->login->id;
            $user->id_user = $this->session->get()->login->id;
            $user->dad =
                $id === 1
                    ? $this->session->get()->login->id
                    : $this->session->get()->login->id . "," . $this->session->get()->login->dad;
        } else {
            $user->dad = 1;
            $user->id_user = 1;
        }

        $user->created_at = date("Y-m-d H:i:s");
        $user->updated_at = date("Y-m-d H:i:s");

        if (!$user->save()) {
            if ($existUpload) {
                $this->upload->delete();
            }
            if ($response === 'json') {
                echo $this->translate->translator($user->response(), "message")->$response();
                return false;
            }
            var_dump($this->translate->translator($user->response(), "message")->$response());
            return false;
        }
        if ($response === 'json') {
            echo $this->translate->translator($user->response(), "message")->$response();
            return true;
        }
        var_dump($this->translate->translator($user->response(), "message")->$response());
        return true;
    }

    public function read($query, string $response): bool
    {

        $this->setRequest($query);
        if (isset($this->query->search)) {
            $this->setSearch($this->query->search);
        }
        $users = new User();
        $arguments = (array)$this->argument;

        if($arguments)
        {
            $find = null;
            foreach ($arguments as $key => $argument) {
                $find .= "$key = :$key AND ";
            }
            $find = substr(trim($find), 0, -4);
            $user = $users->find(condition:  $find, params:  $arguments)->fetch();
            if(!$user){
                echo $this->translate->translator($users->response(), "message")->$response();
                return false;
            }
            echo $this->response->data($user)->$response();
            return true;
        }

        $all = $users->find("id", $this->getFind(), $this->getParams())->count();
        $this->setPaginator($all);
        $this->setOrder();
        $user = $users
            ->find("*", $this->getFind(), $this->getParams())
            ->order($this->getOrder())
            ->limit($this->query->per_page)
            ->offset($this->getOffset())
            ->fetch(true);
        if (!$user) {
            echo $this->translate->translator($users->response(), "message")->$response();
            return false;
        }
        $this->paginator->data = $user;
        echo $this->response->data($this->getPaginator())->$response();
        return true;
    }

    public function edit($query, string $response): bool
    {
        $this->setRequest($query);
        if (!$this->permission()) {
            echo $this->translate->translator($this->getError(), "message")->$response();
        }

        $login = $this->session->get()->login;
        $users = (new User());
        $dad = $users->find('dad',
            'id=:id',
            ['id' => $this->argument->id])
            ->fetch();
        $user = null;


        if ($login->id !== $this->argument->id) {
            $dads = explode(",", $dad->dad);
            foreach ($dads as $dad) {
                if ($dad === $login->id) {
                    $user = $users->find('*',
                        'id=:id',
                        ['id' => $this->argument->id])
                        ->fetch();
                }
            }
        } else {
            $user = $users->find('*',
                'id=:id',
                ['id' => $this->argument->id])
                ->fetch();
        }


        if (!$user) {
            $this->setError(401, "error", "you do not have permission to make this edit");
            echo $this->translate->translator($this->getError(), "message")->json();
            return false;
        }
        foreach ($this->data as $key => $value) {
            if (
                ($key === 'email')
                &&
                (new User())->find('id', 'email=:email', ['email' => $this->data->$key])->fetch()
                &&
                $this->data->$key !== $user->email
            ) {
                $this->setError(401, "error", "this email already exists");
                echo $this->translate->translator($this->getError(), "message")->json();
                return false;
            }
            if ($key === 'password') {
                $this->data->$key = password_hash($value, PASSWORD_BCRYPT, ['cost' => 12]);
            }
            $user->$key = $this->data->$key;
        }
        if(isset($user->updated_at)){
            $user->updated_at = date("Y-m-d H:i:s");
        }
        if (!$users->save()) {
            $this->setError(401, "error", "error saving");
            echo $this->translate->translator($this->getError(), "message")->json();
            return false;
        }
        if ($login->id === $this->argument->id) {
            $this->session->destroy('login');
            $this->session->set('login', $user);
        }
        echo $this->translate->translator($users->response(), "message")->json();
        return true;
    }

    public function destroy($query, string $response): bool
    {
        $this->setRequest($query);
        if (!$this->permission()) {
            echo $this->translate->translator($this->getError(), "message")->json();
            return false;
        }
        $login = $this->session->get()->login;
        if ($login->id === $this->argument->id) {
            $this->setError(401, "error", "you cannot delete your registration");
            echo $this->translate->translator($this->getError(), "message")->json();
            return false;
        }

        $users = (new User());
        $dad = $users->find('dad',
            'id=:id',
            ['id' => $this->argument->id])
            ->fetch();
        $user = null;

        if (!$dad) {
            $this->setError(401, "error", "this data does not exist");
            echo $this->translate->translator($this->getError(), "message")->json();
            return false;
        }

        $dads = explode(",", $dad->dad);
        foreach ($dads as $dad) {
            if ($dad === $login->id) {
                $user = $users->find('*',
                    'id=:id',
                    ['id' => $this->argument->id])
                    ->fetch();
            }
        }

        if (!$user) {
            $this->setError(401, "error", "you do not have permission to make this delete");
            echo $this->translate->translator($this->getError(), "message")->json();
            return false;
        }

        $users->delete($this->argument->id);
        $this->setError(200, "success", "registration successfully deleted");
        echo $this->translate->translator($this->getError(), "message")->json();
        return true;
    }

    private function permission(): bool
    {
        if (!$this->validateLogin()) {
            return false;
        }
        if (isset($this->data->level) && $this->data->level > $this->session->get()->login->level) {
            $this->setError(
                401,
                "error",
                "you do not have permission to make this edit -> user level min {$this->data->level}");
            return false;
        }
        return true;
    }
}