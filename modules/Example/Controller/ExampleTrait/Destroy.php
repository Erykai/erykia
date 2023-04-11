<?php

namespace Modules\Example\Controller\ExampleTrait;

use Source\Core\Cryption;
use Modules\Example\Model\Example;

trait Destroy
{
    public function destroy(array $query, string $response): bool
    {
        $this->setRequest($query);
        if (!$this->permission()) {
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }
        $id = Cryption::getInstance()->decrypt($this->argument->id);
        $login = $this->session->get()->login;
        if ($login->id === $this->argument->id) {
            $this->setResponse(401, "error", "you cannot delete your registration", "delete");
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }

        $examples = (new Example());
        $dad = $examples->find('examples.dad',
            'examples.id=:id',
            ['id' => $id])
            ->fetchReference(getColumns: $this->getColumns());
        $example = null;

        if (!$dad) {
            $this->setResponse(401, "error", "this example does not exist", "delete");
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }

        $dads = explode(",", $dad->dad);
        foreach ($dads as $dad) {
            if ($dad === Cryption::getInstance()->decrypt($login->id)) {
                $example = $examples->find('*',
                    'examples.id=:id',
                    ['id' => $id])
                    ->fetchReference(getColumns: $this->getColumns());
            }
        }

        if (!$example) {
            $this->setResponse(401, "error", "you do not have permission to make this delete", "delete");
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }

        $examples->delete($id);
        $this->setResponse(200, "success", "registration successfully deleted", "delete");
        echo $this->translate->translator($this->getResponse(), "message")->json();
        return true;
    }
}