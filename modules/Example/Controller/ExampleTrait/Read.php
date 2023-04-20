<?php

namespace Modules\Example\Controller\ExampleTrait;

use Source\Core\Cryption;
use Source\Core\Helper;
use Source\Core\Response;
use Modules\Example\Model\Example;

trait Read
{
    public function read(array $query, string $response): bool
    {
        //verify if draw is set datatable
        if (isset($query['query']['draw'])) {
            $query['query'] = $this->datatable($query['query'], 'examples');
        }
        $this->setRequest($query);
        if (isset($this->query->search)) {
            $this->setSearch($this->query->search ,'examples');
        }

        $examples = new Example();

        $params = (array)$this->argument;
        if ($params) {
            if (isset($params['id'])) {
                $params['id'] = Cryption::getInstance()->decrypt($params['id']);
            }

            $find = null;
            foreach ($params as $key => $param) {
                $find .= "examples.$key = :$key AND ";
            }
            $find = substr(trim($find), 0, -4);
            $this->setFind($find . " AND " . $this->getFind());
            if($this->getParams()){
                $params = array_merge($params, $this->getParams());
            }
            $this->setParams($params);
        }

        $result = $examples->find("examples.id", $this->getFind(), $this->getParams())->fetchReference(count: true);
        $this->setPaginator($result);
        $this->setOrder();
        $this->setColumns();
        $example = $examples
            ->find("*", $this->getFind(), $this->getParams())
            ->order($this->getOrder())
            ->limit($this->query->per_page)
            ->offset($this->getOffset())
            ->fetchReference(true, $this->getColumns());
        if (!$example) {
            echo $this->translate->translator($examples->response(), "message")->$response();
            return false;
        }
        $this->paginator->data = $example;
        echo Response::getInstance()->data($this->getPaginator())->$response();
        return true;
    }
}