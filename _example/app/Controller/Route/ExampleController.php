<?php

namespace Source\Controller\Namespace;

use Source\Core\Auth;
use Source\Core\Controller;
use Source\Core\Response;
use Source\Core\Upload;
use Source\Model\Example;
//Namespace examples Example example
class ExampleController extends Controller
{
    use Auth;

    public function store($query, string $response): bool
    {
        $this->setRequest($query);

        if (!$this->permission()) {
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }

        if ($this->request->response()->type === "error") {
            echo $this->translate->translator($this->request->response(), "message")->$response();
            return false;
        }

        $this->upload = new Upload();
        if ($this->upload->response()->type === "error") {
            echo $this->translate->translator($this->upload->response(), "message")->$response();
            return false;
        }

        $example = new Example();
        if ($this->upload->save()) {
            foreach ($this->upload->response()->data as $key => $value) {
                $example->$key = $value;
                $this->setIssetUpload(true);
            }
        }
        foreach ($this->data as $key => $value) {
            $example->$key = $value;
        }
        if ($this->validateLogin()) {
            $id = (int)$this->session->get()->login->id;
            $example->id_users = $this->session->get()->login->id;
            $example->dad =
                $id === 1
                    ? $this->session->get()->login->id
                    : $this->session->get()->login->id . "," . $this->session->get()->login->dad;
        } else {
            $example->dad = 1;
            $example->id_users = 1;
        }

        $example->created_at = date("Y-m-d H:i:s");
        $example->updated_at = date("Y-m-d H:i:s");

        if (!$example->save()) {
            if ($this->isIssetUpload()) {
                $this->upload->delete();
            }
            echo $this->translate->translator($example->response(), "message")->$response();
            return false;
        }
        echo $this->translate->translator($example->response(), "message")->$response();
        return true;
    }

    public function read($query, string $response): bool
    {
        $this->setRequest($query);
        if (isset($this->query->search)) {
            $this->setSearch($this->query->search);
        }
        $examples = new Example();
        $arguments = (array)$this->argument;

        if ($arguments) {
            $find = null;
            foreach ($arguments as $key => $argument) {
                $find .= "$key = :$key AND ";
            }
            $find = substr(trim($find), 0, -4);
            $example = $examples->find(condition: $find, params: $arguments)->fetchReference(getColumns: $this->getColumns());
            if (!$example) {
                echo $this->translate->translator($examples->response(), "message")->$response();
                return false;
            }
            echo (new Response())->data($example)->$response();
            return true;
        }

        $all = $examples->find("examples.id", $this->getFind(), $this->getParams())->fetchReference(count: true);
        $this->setPaginator($all);
        $this->setOrder();
        $this->setColumns();
        $example = $examples
            ->find("*", $this->getFind(), $this->getParams())
            ->order($this->getOrder())
            ->limit($this->query->per_page)
            ->offset($this->getOffset())
            ->fetchReference(true, $this->getColumns());
        if (!$example) {
            echo $this->translate->translator($examples->response(), "message")->$response();
            return false;
        }
        $this->paginator->data = $example;
        echo (new Response())->data($this->getPaginator())->$response();
        return true;
    }

    public function edit($query, string $response): bool
    {
        $this->setRequest($query);
        if (!$this->permission()) {
            echo $this->translate->translator($this->getResponse(), "message")->$response();
        }

        $login = $this->session->get()->login;
        $examples = (new Example());
        $dad = $examples->find('examples.dad',
            'examples.id=:id',
            ['id' => $this->argument->id])
            ->fetch();
        $example = null;

        if(!$dad){
            $this->setResponse(401, "error", "this example does not exist", "edit");
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }

        if ($login->id !== $this->argument->id) {
            $dads = explode(",", $dad->dad);
            foreach ($dads as $dad) {
                if ($dad === $login->id) {
                    $example = $examples->find('*',
                        'examples.id=:id',
                        ['id' => $this->argument->id])
                        ->fetch();
                }
            }
        } else {
            $example = $examples->find('*',
                'examples.id=:id',
                ['id' => $this->argument->id])
                ->fetch();
        }


        if (!$example) {
            $this->setResponse(401, "error", "you do not have permission to make this edit", "edit");
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }

        foreach ($this->data as $key => $value) {
            if (
                ($key === 'email')
                &&
                (new Example())->find('id', 'email=:email', ['email' => $this->data->$key])->fetch()
                &&
                $this->data->$key !== $example->email
            ) {
                $this->setResponse(401, "error", "this email already exists","edit");
                echo $this->translate->translator($this->getResponse(), "message")->json();
                return false;
            }
            if ($key === 'password') {
                $this->data->$key = password_hash($value, PASSWORD_BCRYPT, ['cost' => 12]);
            }
            $example->$key = $this->data->$key;
        }
        if (isset($example->updated_at)) {
            $example->updated_at = date("Y-m-d H:i:s");
        }

        $this->upload = new Upload();
        if ($this->upload->response()->type === "error") {
            echo $this->translate->translator($this->upload->response(), "message")->$response();
            return false;
        }

        if ($this->upload->save()) {
            foreach ($this->upload->response()->data as $key => $value) {
                $example->$key = $value;
                $this->setIssetUpload(true);
            }
        }
        if (!$examples->save()) {
            if ($this->isIssetUpload()) {
                $this->upload->delete();
            }
            $this->setResponse(401, "error", "error saving","edit");
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }
        if ($login->id === $this->argument->id) {
            $this->session->destroy('login');
            $this->session->set('login', $example);
        }
        echo $this->translate->translator($examples->response(), "message")->json();
        return true;
    }

    public function destroy($query, string $response): bool
    {
        $this->setRequest($query);
        if (!$this->permission()) {
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }
        $login = $this->session->get()->login;
        //if users not delete my user
//        if ($login->id === $this->argument->id) {
//            $this->setResponse(401, "error", "you cannot delete your registration");
//            echo $this->translate->translator($this->getResponse(), "message")->json();
//            return false;
//        }

        $examples = (new Example());
        $dad = $examples->find('examples.dad',
            'examples.id=:id',
            ['id' => $this->argument->id])
            ->fetch();
        $example = null;

        if (!$dad) {
            $this->setResponse(401, "error", "this example does not exist", "delete");
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }

        $dads = explode(",", $dad->dad);
        foreach ($dads as $dad) {
            if ($dad === $login->id) {
                $example = $examples->find('*',
                    'examples.id=:id',
                    ['id' => $this->argument->id])
                    ->fetch();
            }
        }

        if (!$example) {
            $this->setResponse(401, "error", "you do not have permission to make this delete", "delete");
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }

        $examples->delete($this->argument->id);
        $this->setResponse(200, "success", "registration successfully deleted", "delete");
        echo $this->translate->translator($this->getResponse(), "message")->json();
        return true;
    }
}