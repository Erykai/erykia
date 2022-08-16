<?php
/*
use Source\Core\CreateDatabase;
require "vendor/autoload.php";
$create = new CreateDatabase();
$create->table('posts');
$create->column('id')->type('int(11)')->default();
$create->column('id_user')->type('int(11)')->default();
$create->column('id_category')->type('int(11)')->default();
$create->column('title')->type('varchar(255)')->default();
$create->column('description')->type('text')->default();
$create->column('cover')->type('varchar(255)')->default()->null();
$create->column('created_at')->type('timestamp')->default("current_timestamp()");
$create->column('updated_at')->type('timestamp')->default("current_timestamp() ON UPDATE current_timestamp()");
$create->save();
$create->primary('id');
$create->autoIncrement('id');
$create->addKey('users_posts', "id_user", "users", "id");
$create->addKey('posts_categories', "id_category", "posts_categories", "id");
*/