<?php

namespace Source\Controller\Ia;

use Source\Core\Controller;
use Source\Model\User;

class IaUserController extends Controller
{

    public function store(): bool
    {
        $this->setRequest(null);
        if (isset($this->data->exist)) {
            $user = new User();
            if($user->find()->count() > 0){
                echo '{ "exist": true }';
            }else{
                echo '{ "exist": false }';
            }
            return true;
        }

            $user = new User();
            foreach ($this->data as $key => $value) {
                $user->$key = $value;
            }
            $user->id_user = 1;
            $user->dad = 1;
            $user->level = 10;
            if (!$user->save()) {
                $error['error'] = $this->translate
                    ->translator($user->response(), "message")->object()->translate;
                $error['error'] .= $this->translate
                    ->translatorString(" - type 2 to update your data", "ia")
                    ->object()->translate;
                echo json_encode($error);
                return false;
            }
            $message['user'] = $this->translate
                ->translator($user->response(), "message")
                ->object()->translate;
            echo json_encode($message);
        return true;
    }
}