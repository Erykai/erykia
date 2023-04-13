<?php

namespace Modules\User\Controller\UserTrait;

use Source\Core\Cryption;
use Source\Core\Response;
use Modules\User\Model\User;

trait Read
{
    public function read(array $query, string $response): bool
    {
        //verify if draw is set datatable
        if (isset($query['query']['draw'])) {
            $query['query'] = $this->datatable($query['query'], 'users');
        }
        $this->setRequest($query);
        if (isset($this->query->search)) {
            $this->setSearch($this->query->search ,'users');
        }

        $users = new User();

        $params = (array)$this->argument;
        if ($params) {
            if (isset($params['id'])) {
                $params['id'] = Cryption::getInstance()->decrypt($params['id']);
            }

            $find = null;
            foreach ($params as $key => $param) {
                $find .= "users.$key = :$key AND ";
            }
            $find = substr(trim($find), 0, -4);
            $this->setFind($find . " AND " . $this->getFind());
            if($this->getParams()){
                $params = array_merge($params, $this->getParams());
            }
            $this->setParams($params);
        }
        $result = $users->find("users.id", $this->getFind(), $this->getParams())->fetchReference(count: true);
        $this->setPaginator($result);
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
        echo Response::getInstance()->data($this->getPaginator())->$response();
        return true;
    }
}