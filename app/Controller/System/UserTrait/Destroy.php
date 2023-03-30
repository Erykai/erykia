<?php

namespace Source\Controller\System\UserTrait;

use Source\Model\User;

trait Destroy
{
    public function destroy(array $query, string $response): bool
    {
        $this->setRequest($query);
        if (!$this->permission()) {
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }
        $login = $this->session->get()->login;
        if ($login->id === $this->argument->id) {
            $this->setResponse(401, "error", "you cannot delete your registration", "delete");
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }

        $users = (new User());
        $dad = $users->find('users.dad',
            'users.id=:id',
            ['id' => $this->argument->id])
            ->fetchReference(getColumns: $this->getColumns());
        $user = null;

        if (!$dad) {
            $this->setResponse(401, "error", "this user does not exist", "delete");
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }

        $dads = explode(",", $dad->dad);
        foreach ($dads as $dad) {
            if ($dad === $login->id) {
                $user = $users->find('*',
                    'users.id=:id',
                    ['id' => $this->argument->id])
                    ->fetchReference(getColumns: $this->getColumns());
            }
        }

        if (!$user) {
            $this->setResponse(401, "error", "you do not have permission to make this delete", "delete");
            echo $this->translate->translator($this->getResponse(), "message")->json();
            return false;
        }

        $users->delete($this->argument->id);
        $this->setResponse(200, "success", "registration successfully deleted", "delete");
        echo $this->translate->translator($this->getResponse(), "message")->json();
        return true;
    }
}