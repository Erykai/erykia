<?php

namespace Source\Controller\Web;

use Source\Core\Auth;
use Source\Core\Controller;
use Source\Core\Request;
use Source\Core\Response;
use Source\Core\Upload;
use Source\Model\User;

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
            if($response === 'json'){
               echo $this->response->data($this->request->response())->lang()->$response();
            }else{
                var_dump($this->response->data($this->request->response())->lang()->$response());
            }
            return false;
        }
        $this->user = $this->request->response()->data->request;
        $this->query = $this->request->response()->data->query;
        $this->argument = $this->request->response()->data->argument;

        $this->upload = new Upload();
        if ($this->upload->response()->type === "error") {
            if($response === 'json'){
                echo $this->response->data($this->upload->response())->lang()->$response();
            }else{
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
            if($response === 'json'){
                echo $this->response->data($user->response())->lang()->$response();
            }else{
                var_dump($this->response->data($user->response())->lang()->$response());
            }
            return false;
        }
        if($response === 'json'){
            echo $this->response->data($user->response())->lang()->$response();
        }else{
            var_dump($this->response->data($user->response())->lang()->$response());
        }
        return true;
    }
    public function read($query, string $response)
    {

        $this->request = new Request($query);
        $this->response = new Response();

        $this->user = $this->request->response()->data->request;
        $this->query = $this->request->response()->data->query;
        $this->argument = $this->request->response()->data->argument;

        $users = new User();
        //$user = $users->find("*", "id=:id", ["id" => $this->argument->id])->fetch(true);
        $user = $users->find()->fetch(true);

        echo $this->response->data($user)->$response();


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