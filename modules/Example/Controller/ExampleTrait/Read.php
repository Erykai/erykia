<?php

namespace Modules\Example\Controller\ExampleTrait;

use Source\Core\Cryption;
use Source\Core\Response;
use Modules\Example\Model\Example;

trait Read
{
    public function read(array $query, string $response): bool
    {
        //verify if draw is set datatable
        if(isset($query['query']['draw'])){
            $query['query'] = $this->datatable($query['query']);
        }
        $this->setRequest($query);
        if (isset($this->query->search)) {
            $this->setSearch($this->query->search);
        }

        $examples = new Example();

        $arguments = (array)$this->argument;
        if(isset($arguments['id'])){
            $arguments['id'] = (new Cryption())->decrypt($arguments['id']);
        }

        if ($arguments) {
            $find = null;
            foreach ($arguments as $key => $argument) {
                $find .= "$key = :$key AND ";
            }
            $find = substr(trim($find), 0, -4);
            $example = $examples->find(condition: $find, params: $arguments)->fetchReference(all: true, getColumns: $this->getColumns());

            if (!$example) {
                echo $this->translate->translator($examples->response(), "message")->$response();
                return false;
            }
            $this->setPaginator(1);
            $this->paginator->data = $example;
            echo (new Response())->data($this->getPaginator())->$response();
            return true;
        }

        $all = $examples->find("examples.id", $this->getFind(), $this->getParams())->fetchReference(count: true);
        $this->setPaginator($all);
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
        echo (new Response())->data($this->getPaginator())->$response();
        return true;
    }
}