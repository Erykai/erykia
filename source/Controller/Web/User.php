<?php

namespace Source\Controller\Web;

use Source\Core\Controller;
use Source\Core\Request;
use Source\Core\Upload;

class User extends Controller
{
    protected object $user;
    protected object $query;
    protected object $request;

    public function store(?array $query = null): bool
    {
        $this->request = new Request($query);
        //get all data sent via POST or JSON and convert in object
        //example $this->user->name = tal
        $this->user = $this->request->data();
        //get all data sent via GET query ?name=tal&order=ASC and convert to object
        //example $this->user->query->name = tal
        if($this->request->query()){
            $this->query = $this->request->query();
        }
        //get FILES validate the mimetype
        $upload = new Upload();
        if ($upload->getError()) {
            echo $upload->getError();
            return false;
        }
        //start a new object
        $user = new \Source\Model\User();
        $file = false;
        //check if there was upload
        if($upload->save()){
            foreach ($upload->getResponse() as $key => $value) {
                //add FILES key as object
                //example $user->cover = 'storage/image/2022/08/10/image.jpg'
                //example $user->profile = 'storage/image/2022/08/10/profile.jpg'
                $user->$key = $value;
                //activate to check if there was an upload, to remove the files if the data is not saved
                $file = true;
            }
        }
        foreach ($this->user as $key => $value) {
            $user->$key = $value;
        }

        if (!$user->save()) {
            if($file){
                //remove uploads if you don't save data
                $upload->delete();
            }
            echo $user->error();
            return false;
        }
        echo t("registration successful");
        return true;
    }

    public function read(?array $query = null)
    {
        $this->request = new Request($query);
        $id = $this->request->argument()->id;

        $users = new \Source\Model\User();
        $user = $users->find("*", "id=:id",["id"=>$id])->fetch(true);
        var_dump($user);
    }

    public function edit($query = null)
    {
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
    }

    public function destroy(array $data)
    {
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
    }
}