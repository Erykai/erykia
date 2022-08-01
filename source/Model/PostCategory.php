<?php

namespace Source\Model;

use Source\Core\Model;

class PostCategory extends Model
{
public function __construct()
{
    parent::__construct('posts_categories', [
        'user_id',
        'slug',
        'title'
    ]);
}
}