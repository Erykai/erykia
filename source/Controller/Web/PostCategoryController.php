<?php

namespace Source\Controller\Web;

use Source\Core\Auth;
use Source\Core\Controller;
use Source\Core\Upload;
use Source\Model\PostCategory;

class PostCategoryController extends Controller
{
    use Auth;

    public function store($query, string $response)
    {
        $this->setRequest($query);

        if((new PostCategory())->find('id')->fetch() && !$this->permission()) {
            echo $this->response->data($this->getError())->lang()->$response();
            return false;
        }

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

        $post_category = new PostCategory();
        $existUpload = false;
        if ($this->upload->save()) {
            foreach ($this->upload->response()->data as $key => $value) {
                $post_category->$key = $value;
                $existUpload = true;
            }
        }
        foreach ($this->data as $key => $value) {
            $post_category->$key = $value;
        }
        if ($this->validateLogin()) {
            $id = (int)$this->session->get()->login->id;
            $post_category->id_user = $this->session->get()->login->id;
            $post_category->dad =
                $id === 1
                    ? $this->session->get()->login->id
                    : $this->session->get()->login->id . "," . $this->session->get()->login->dad;
        } else {
            $post_category->dad = 1;
            $post_category->id_user = 1;
        }

        $post_category->created_at = date("Y-m-d H:i:s");
        $post_category->updated_at = date("Y-m-d H:i:s");

        if (!$post_category->save()) {
            if ($existUpload) {
                $this->upload->delete();
            }
            if ($response === 'json') {
                echo $this->response->data($post_category->response())->lang()->$response();
                return false;
            }
            var_dump($this->response->data($post_category->response())->lang()->$response());
            return false;
        }
        if ($response === 'json') {
            echo $this->response->data($post_category->response())->lang()->$response();
            return true;
        }
        var_dump($this->response->data($post_category->response())->lang()->$response());
        return true;
    }

    public function read($query, string $response)
    {
        $this->setRequest($query);
        if (isset($this->query->search)) {
            $this->setSearch($this->query->search);
        }
        $posts_categories = new PostCategory();
        $all = $posts_categories->find("id", $this->getFind(), $this->getParams())->count();
        $this->setPaginator($all);
        $this->setOrder();
        $post_category = $posts_categories
            ->find("*", $this->getFind(), $this->getParams())
            ->order($this->getOrder())
            ->limit($this->query->per_page)
            ->offset($this->getOffset())
            ->fetch(true);
        if (!$post_category) {
            echo $this->response->data($posts_categories->response())->lang()->$response();
            return false;
        }
        $this->paginator->data = $post_category;
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
        $posts_categories = (new PostCategory());
        $dad = $posts_categories->find('dad',
            'id=:id',
            ['id' => $this->argument->id])
            ->fetch();
        $post_category = null;


        if ($login->id !== $this->argument->id) {
            $dads = explode(",", $dad->dad);
            foreach ($dads as $dad) {
                if ($dad === $login->id) {
                    $post_category = $posts_categories->find('*',
                        'id=:id',
                        ['id' => $this->argument->id])
                        ->fetch();
                }
            }
        } else {
            $post_category = $posts_categories->find('*',
                'id=:id',
                ['id' => $this->argument->id])
                ->fetch();
        }
        if(isset($post_category->updated_at)){
            $post_category->updated_at = date("Y-m-d H:i:s");
        }

        if (!$post_category) {
            $this->setError(401, "error", "you do not have permission to make this edit");
            echo $this->response->data($this->getError())->lang()->json();
            return false;
        }
        foreach ($this->data as $key => $value) {
            if (
                ($key === 'email') &&
                (new PostCategory())->find('id', 'email=:email', ['email' => $this->data->$key])->fetch() &&
                $this->data->$key !== $post_category->email
            ) {
                $this->setError(401, "error", "this email already exists");
                echo $this->response->data($this->getError())->lang()->json();
                return false;
            }
            if ($key === 'password') {
                $this->data->$key = password_hash($value, PASSWORD_BCRYPT, ['cost' => 12]);
            }
            $post_category->$key = $this->data->$key;
        }
        if(isset($post_category->updated_at)){
            unset($post_category->updated_at);
        }
        if (!$posts_categories->save()) {
            $this->setError(401, "error", "error saving");
            echo $this->response->data($this->getError())->lang()->json();
            return false;
        }
        if ($login->id === $this->argument->id) {
            $this->session->destroy('login');
            $this->session->set('login', $post_category);
        }
        echo $this->response->data($posts_categories->response())->lang()->json();
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

        $posts_categories = (new PostCategory());
        $dad = $posts_categories->find('dad',
            'id=:id',
            ['id' => $this->argument->id])
            ->fetch();
        $post_category = null;

        if (!$dad) {
            $this->setError(401, "error", "this data does not exist");
            echo $this->response->data($this->getError())->lang()->json();
            return false;
        }

        $dads = explode(",", $dad->dad);
        foreach ($dads as $dad) {
            if ($dad === $login->id) {
                $post_category = $posts_categories->find('*',
                    'id=:id',
                    ['id' => $this->argument->id])
                    ->fetch();
            }
        }

        if (!$post_category) {
            $this->setError(401, "error", "you do not have permission to make this delete");
            echo $this->response->data($this->getError())->lang()->json();
            return false;
        }

        $posts_categories->delete($this->argument->id);
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
            $this->setError(401, "error", "you do not have permission to make this edit -> post_category level min {$this->data->level}");
            return false;
        }
        return true;
    }
}