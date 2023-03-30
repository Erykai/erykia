<?php

namespace Source\Controller\System\UserTrait;

use Source\Core\Response;
use Source\Model\User;

trait Read
{
    public function read(array $query, string $response): bool
    {
        $this->setRequest($query);
        if (isset($this->query->search)) {
            $this->setSearch($this->query->search);
        }
        $users = new User();
        $arguments = (array)$this->argument;

        if ($arguments) {
            $find = null;
            foreach ($arguments as $key => $argument) {
                $find .= "$key = :$key AND ";
            }
            $find = substr(trim($find), 0, -4);
            $user = $users->find(condition: $find, params: $arguments)->fetchReference(getColumns: $this->getColumns());
            if (!$user) {
                echo $this->translate->translator($users->response(), "message")->$response();
                return false;
            }
            echo (new Response())->data($user)->$response();
            return true;
        }

        $all = $users->find("users.id", $this->getFind(), $this->getParams())->fetchReference(count: true);
        $this->setPaginator($all);
        $this->setOrder();
        $this->setColumns();
        $user = $users
            ->find("*", $this->getFind(), $this->getParams())
            ->order($this->getOrder())
            ->limit($this->query->per_page)
            ->offset($this->getOffset())
            ->fetchReference(true, $this->getColumns());
        if (!$user) {
            echo $this->translate->translator($users->response(), "message")->$response();
            return false;
        }
        $this->paginator->data = $user;
        echo (new Response())->data($this->getPaginator())->$response();
        return true;
    }
}