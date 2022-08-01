<?php

namespace Source\Model;

use Source\Core\Model;

class Post extends Model
{
public function __construct()
{
    parent::__construct('posts', [
        'user_id',
        'category_id',
        'slug',
        'title',
        'subtitle',
        'description',
        'cover',
        'published_start'
    ]);
}
}