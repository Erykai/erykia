<?php

namespace Source\Controller\Web;

use Source\Core\Controller;
use Source\Core\Helper;

class PostCategoryController extends Controller
{

    public function read(): void
    {

    }

    public function store(): bool
    {
        if(!$this->validateLogin()){
            echo $this->getError();
            return false;
        }
        $postCategory = new \Source\Model\PostCategory();
        $categories = $this->getData();
        foreach ($categories as $key => $category) {
            $postCategory->$key = $category;
        }
        if(!isset($postCategory->title)){
            $this->setError(t('the title is mandatory'));
            echo $this->getError();
            return false;
        }
        $postCategory->slug = Helper::slug($postCategory->title);
        if((new \Source\Model\PostCategory())
            ->find('slug', 'slug=:slug', ['slug'=> $postCategory->slug])
            ->fetch()){
            $postCategory->slug .= "-" . time();
        }
        $postCategory->user_id = (int) $this->login->id;
        if(!$postCategory->save()){
            echo $this->getError();
            return false;
        }
        return true;
    }

    public function edit(): void
    {

    }

    public function destroy(): void
    {

    }
}