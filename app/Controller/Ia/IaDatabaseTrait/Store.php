<?php

namespace Source\Controller\Ia\IaDatabaseTrait;

trait Store
{
    public function store(): bool
    {
        $file = dirname(__DIR__, 4) . "/.env";
        $this->setRequest(null);
        if (isset($this->data->env)) {
            if (is_file($file)) {
                echo '{ "env": true }';
            } else {
                echo '{ "env": false }';
            }
            return true;
        }
        $this->conn(
            $this->data->driver,
            $this->data->host,
            $this->data->base,
            $this->data->username,
            $this->data->password
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
CONN_PASS=' . $this->data->password . '
CONN_BASE=' . $this->data->base . '
CONN_HOST=' . $this->data->host . '
CONN_DSN=' . $this->data->driver . '
###JWT###
KEY_JWT=' . $this->data->cryptography . '
###ERYKIA###
ERYKIA_PORT=80
ERYKIA_SSL_PORT=443
ERIKIA_DB_PORT=3306
';
            file_put_contents($file, $data);
            $database['database'] = $this->translate
                ->translatorString("database data was created successfully", "ia")
                ->object()->translate;
            echo json_encode($database);
        }
        return true;
    }
}