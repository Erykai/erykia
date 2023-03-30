<?php

namespace Modules\Namespace\Controller\ExampleTrait;

use Modules\Namespace\Model\Example;

trait Destroy
{
    public function destroy($query, string $response): bool
    {
        $this->setRequest($query);
        if (!$this->permission()) {
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }
        $login = $this->session->get()->login;

        $examples = (new Example());
        $dad = $examples->find('examples.dad',
            'examples.id=:id',
            ['id' => $this->argument->id])
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
                    ['id' => $this->argument->id])
                    ->fetch();
            }
        }

        if (!$example) {
            $this->setResponse(401, "error", "you do not have permission to make this delete", "delete");
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }

        $examples->delete($this->argument->id);
        $this->setResponse(200, "success", "registration successfully deleted", "delete");
        echo $this->translate->translator($this->getResponse(), "message")->json();
        return true;
    }
}