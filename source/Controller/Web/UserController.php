<?php

namespace Source\Controller\Web;

use Source\Core\Auth;
use Source\Core\Controller;
use Source\Core\Upload;
use Source\Model\User;

class UserController extends Controller
{
    use Auth;

    public function store($query, string $response)
    {
        $this->setRequest($query);
        if ($this->request->response()->type === "error") {
            if ($response === 'json') {
                echo $this->response->data($this->request->response())->lang()->$response();
            } else {
                var_dump($this->response->data($this->request->response())->lang()->$response());
            }
            return false;
        }

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
                $user->$key = $value;
                $existUpload = true;
            }
        }
        foreach ($this->data as $key => $value) {
            $user->$key = $value;
        }
        if ($this->validateLogin()) {
            $id = (int)$this->session->get()->login->id;
            $user->dad =
                $id === 1
                    ? $this->session->get()->login->id
                    : $this->session->get()->login->id . "," . $this->session->get()->login->dad;
        } else {
            $user->dad = 1;
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
        $this->setRequest($query);
        if (isset($this->query->search)) {
            $this->setSearch($this->query->search);
        }
        $users = new User();
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
            echo $this->response->data($users->response())->lang()->$response();
            return false;
        }
        $this->paginator->data = $user;
        echo $this->response->data($this->getPaginator())->$response();
        return true;
    }

    public function edit($query, string $response)
    {
        $this->setRequest($query);
        if (!$this->permission()) {
            echo $this->response->data($this->getError())->lang()->$response();
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
            echo $this->response->data($this->getError())->lang()->json();
            return false;
        }
        foreach ($this->data as $key => $value) {
            if (
                ($key === 'email') &&
                (new User())->find('id', 'email=:email', ['email' => $this->data->$key])->fetch() &&
                $this->data->$key !== $user->email
            ) {
                $this->setError(401, "error", "this email already exists");
                echo $this->response->data($this->getError())->lang()->json();
                return false;
            }
            if ($key === 'password') {
                $this->data->$key = password_hash($value, PASSWORD_BCRYPT, ['cost' => 12]);
            }
            $user->$key = $this->data->$key;
        }
        if (!$users->save()) {
            $this->setError(401, "error", "error saving");
            echo $this->response->data($this->getError())->lang()->json();
            return false;
        }
        if ($login->id === $this->argument->id) {
            $this->session->destroy('login');
            $this->session->set('login', $user);
        }
        return true;
    }

    public function destroy($query, string $response): bool
    {
        $this->setRequest($query);
        if (!$this->permission()) {
            echo $this->response->data($this->getError())->lang()->$response();
            return false;
        }
        $login = $this->session->get()->login;
        if ($login->id === $this->argument->id) {
            $this->setError(401, "error", "you cannot delete your registration");
            echo $this->response->data($this->getError())->lang()->json();
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
            echo $this->response->data($this->getError())->lang()->json();
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
            echo $this->response->data($this->getError())->lang()->json();
            return false;
        }

        $users->delete($this->argument->id);
        $this->setError(200, "success", "registration successfully deleted");
        echo $this->response->data($this->getError())->lang()->json();
        return true;
    }

    private function permission(): bool
    {
        if (!$this->validateLogin()) {
            return false;
        }
        if (isset($this->data->level) && $this->data->level > $this->session->get()->login->level) {
            $this->setError(401, "error", "you do not have permission to make this edit -> user level min {$this->data->level}");
            return false;
        }
        return true;
    }
}