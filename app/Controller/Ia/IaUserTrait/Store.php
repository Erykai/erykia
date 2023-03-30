<?php

namespace Source\Controller\Ia\IaUserTrait;

use Source\Model\User;

trait Store
{
    public function store(): bool
    {
        $this->setRequest(null);
        $user = new User();
        if (isset($this->data->exist)) {
            if($user->find()->count() > 0){
                echo '{ "exist": true }';
            }else{
                echo '{ "exist": false }';
            }
            return true;
        }

        foreach ($this->data as $key => $value) {
            $user->$key = $value;
        }
        $user->id_users = 1;
        $user->dad = 1;
        $user->level = 10;
        if (!$user->save()) {
            $error['error'] = $this->translate
                ->translator($user->response(), "message")->object()->text;
            $error['error'] .= $this->translate
                ->translatorString(" - type 2 to update your data", "ia")
                ->object()->text;
            echo json_encode($error);
            return false;
        }
        $message['user'] = $this->translate->translator($user->response(), "message")->object()->text;
        echo json_encode($message);
        return true;
    }
}