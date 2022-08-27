<?php

namespace Source\Controller\Ia;

use Erykai\Database\Database;
use Source\Core\Controller;
use Source\Model\User;

class IaController extends Controller
{
    public function read(): void
    {
        require dirname(__DIR__, 3) . "/erykia/views/chat.html";
    }

    public function store(): bool
    {
        $file = dirname(__DIR__, 3) . "/.env";
        $this->setRequest(null);
        if (isset($this->data->env)) {
            if (is_file($file)) {
                echo '{ "env": true }';
                return true;
            }
            echo '{ "env": false }';
        }

        if (isset($this->data->exist)) {
            $user = new User();
            if($user->find()->count() > 0){
                echo '{ "exist": true }';
                return true;
            }
            echo '{ "exist": false }';
        }

        if (isset($this->data->base)) {
            $this->conn(
                $this->data->driver,
                $this->data->host,
                $this->data->base,
                $this->data->username,
                $this->data->pass
            );
            if (!is_object($this->conn)) {
                echo '{ "error": "' . $this->conn . '"}';
                return false;
            }
            if (empty($this->data->cryptography)) {
                echo '{ "error": "the encryption key is mandatory enter 4 and enter the data correctly"}';
                return false;
            }
            if (!is_file($file)) {
                $data = '###CONN####
CONN_USER=' . $this->data->username . '
CONN_PASS=' . $this->data->pass . '
CONN_BASE=' . $this->data->base . '
CONN_HOST=' . $this->data->host . '
CONN_DSN=' . $this->data->driver . '
###JWT###
KEY_JWT=' . $this->data->cryptography . '';
                file_put_contents($file, $data);
                $database['database'] = $this->translate
                    ->translatorString("database data was created successfully", "ia")
                    ->object()->translate;
                echo json_encode($database);
            }
        }

        if (isset($this->data->name_user)) {
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
        }

        return true;
    }

    public function edit(): void
    {
        echo "editar";
    }

    public function destroy(): void
    {
        echo "deletar";
    }
}