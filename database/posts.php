<?php

use Source\Core\Migration;
$migration = new Migration();
$migration->column('id')->type('int(11)')->default();
$migration->column('id_user')->type('int(11)')->default();
$migration->column('id_category')->type('int(11)')->default();
$migration->column("dad")->type("varchar(255)")->default();
$migration->column('title')->type('varchar(255)')->default();
$migration->column('description')->type('text')->default();
$migration->column('cover')->type('varchar(255)')->default()->null();
$migration->column('created_at')->type('timestamp')->default("current_timestamp()");
$migration->column('updated_at')->type('timestamp')->default("current_timestamp() ON UPDATE current_timestamp()");
$migration->save();
$migration->primary('id');
$migration->autoIncrement('id');
$migration->addKey('users_posts', "id_user", "users", "id");
$migration->addKey('posts_categories', "id_category", "posts_categories", "id");