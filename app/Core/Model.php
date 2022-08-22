<?php

namespace Source\Core;

use Erykai\Database\Database;
use Source\Model\User;

class Model extends Database
{
    protected function emailFilter(): bool
    {
        if (isset($this->email)) {
            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $dynamic = $this->email;
                $this->setResponse(
                    400,
                    "error",
                    "the email format $dynamic is invalid",
                    dynamic: $dynamic
                );
                return false;
            }
            return true;
        }
        return true;
    }

    protected function emailIsset(): bool
    {
        if (isset($this->email)) {
            $users = new User();
            $user = $users->find('id', 'email=:email', ['email' => $this->email])->fetch();
            if ($user) {
                if (!isset($this->id)) {
                    $dynamic = $this->email;
                    $this->setResponse(
                        400,
                        "error",
                        "the email $dynamic already exists",
                        dynamic: $dynamic
                    );
                    return false;
                }
                if ($this->id !== $user->id) {
                    $dynamic = $this->email;
                    $this->setResponse(
                        400,
                        "error",
                        "the email $dynamic already exists in another account",
                        dynamic: $dynamic
                    );

                    return false;
                }
                return true;
            }
            return true;
        }
        return true;
    }

    protected function password(): bool
    {

        if (!empty($this->password)) {
            $this->password = password_hash($this->password, PASSWORD_BCRYPT, ['cost' => 12]);
            return true;
        }
        return true;
    }
}