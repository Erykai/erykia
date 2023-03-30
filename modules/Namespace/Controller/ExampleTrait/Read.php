<?php

namespace Modules\Namespace\Controller\ExampleTrait;

use Modules\Namespace\Model\Example;
use Source\Core\Response;

trait Read
{
    public function read($query, string $response): bool
    {
        $this->setRequest($query);
        if (isset($this->query->search)) {
            $this->setSearch($this->query->search);
        }
        $examples = new Example();
        $arguments = (array)$this->argument;

        if ($arguments) {
            $find = null;
            foreach ($arguments as $key => $argument) {
                $find .= "$key = :$key AND ";
            }
            $find = substr(trim($find), 0, -4);
            $example = $examples->find(condition: $find, params: $arguments)->fetchReference(getColumns: $this->getColumns());
            if (!$example) {
                echo $this->translate->translator($examples->response(), "message")->$response();
                return false;
            }
            echo (new Response())->data($example)->$response();
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