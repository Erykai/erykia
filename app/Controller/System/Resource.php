<?php

namespace Source\Controller\System;

use Source\Core\Controller;
use Modules\User\Model\User;

abstract class Resource extends Controller
{
    public function recovery(array $query, string $response): bool
    {
        $this->setRequest($query);
        if (!$this->validateEmail()) {
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }
        $users = new User();
        $user = $users->find('id,email,recovery', 'email = :email',['email' => $this->data->email])->fetch();
        if (!$user) {
            echo $this->translate->translator($users->response(), "message")->$response();
            return false;
        }

        $user->recovery = sha1($user->email . rand(000000,999999));
        if (!$users->save()) {
            $this->setResponse(401, "error", "error recovery", "recovery");
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }
        $this->setResponse(200, "success", "Your password recovery has been sent to your email", "recovery");
        echo $this->translate->translator($this->getResponse(), "message")->json();
        return true;
    }
}