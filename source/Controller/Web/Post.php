<?php

namespace Source\Controller\Web;

use Source\Core\Controller;
use Source\Core\Helper;

class Post extends Controller
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
        $post = new \Source\Model\Post();
        $posts = $this->getData();
        foreach ($posts as $key => $category) {
            $post->$key = $category;
        }
        if(!isset($post->title)){
            $this->setError(t('the title is mandatory'));
            echo $this->getError();
            return false;
        }
        $post->slug = Helper::slug($post->title);
        if((new \Source\Model\Post())
            ->find('slug', 'slug=:slug', ['slug'=> $post->slug])
            ->fetch()){
            $post->slug .= "-" . time();
        }
        $post->user_id = (int) $this->login->id;
        if(!$post->save()){
            echo $post->error();
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