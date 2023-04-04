<?php

namespace Modules\Namespace\Controller\ExampleTrait;

use Modules\Namespace\Model\Example;
use Source\Core\Cryption;

trait Destroy
{
    public function destroy($query, string $response): bool
    {
        $this->setRequest($query);
        if (!$this->permission()) {
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }
        $id = (new Cryption())->decrypt($this->argument->id);
        $login = $this->session->get()->login;

        $examples = (new Example());
        $dad = $examples->find('examples.dad',
            'examples.id=:id',
            ['id' => $id])
            ->fetch();
        $example = null;

        if (!$dad) {
            $this->setResponse(401, "error", "this example does not exist", "delete");
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }

        $dads = explode(",", $dad->dad);
        foreach ($dads as $dad) {
            if ($dad === $login->id) {
                $example = $examples->find('*',
                    'examples.id=:id',
                    ['id' => $id])
                    ->fetch();
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