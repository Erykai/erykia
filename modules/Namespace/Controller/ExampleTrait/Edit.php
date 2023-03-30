<?php

namespace Modules\Namespace\Controller\ExampleTrait;

use Modules\Namespace\Model\Example;

trait Edit
{
    public function edit($query, string $response): bool
    {
        $this->setRequest($query);
        if (!$this->permission()) {
            echo $this->translate->translator($this->getResponse(), "message")->$response();
        }

        $login = $this->session->get()->login;
        $examples = (new Example());
        $dad = $examples->find('examples.dad',
            'examples.id=:id',
            ['id' => $this->argument->id])
            ->fetch();
        $example = null;

        if (!$dad) {
            $this->setResponse(401, "error", "this example does not exist", "edit");
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }

        if ($login->id !== $this->argument->id) {
            $dads = explode(",", $dad->dad);
            foreach ($dads as $dad) {
                if ($dad === $login->id) {
                    $example = $examples->find('*',
                        'examples.id=:id',
                        ['id' => $this->argument->id])
                        ->fetch();
                }
            }
        } else {
            $example = $examples->find('*',
                'examples.id=:id',
                ['id' => $this->argument->id])
                ->fetch();
        }


        if (!$example) {
            $this->setResponse(401, "error", "you do not have permission to make this edit", "edit");
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }

        foreach ($this->data as $key => $value) {
            if (
                ($key === 'email')
                &&
                (new Example())->find('id', 'email=:email', ['email' => $this->data->$key])->fetch()
                &&
                $this->data->$key !== $example->email
            ) {
                $this->setResponse(401, "error", "this email already exists", "edit");
                echo $this->translate->translator($this->getResponse(), "message")->json();
                return false;
            }
            if ($key === 'password') {
                $this->data->$key = password_hash($value, PASSWORD_BCRYPT, ['cost' => 12]);
            }
            $example->$key = $this->data->$key;
        }
        if (isset($example->updated_at)) {
            $example->updated_at = date("Y-m-d H:i:s");
        }

        $this->setUpload($example);
        if (!$examples->save()) {
            if ($this->isIssetUpload()) {
                $this->upload->delete();
            }
            $this->setResponse(401, "error", "error saving", "edit");
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }
        if ($login->id === $this->argument->id) {
            $this->session->destroy('login');
            $this->session->set('login', $example);
        }
        echo $this->translate->translator($examples->response(), "message")->json();
        return true;
    }
}