<?php
/*
use Source\Core\CreateDatabase;
require "vendor/autoload.php";
$create = new CreateDatabase();
$create->table('posts_categories');
$create->column('id')->type('int(11)')->default();
$create->column('id_user')->type('int(11)')->default();
$create->column('title')->type('varchar(255)')->default();
$create->column('created_at')->type('timestamp')->default("current_timestamp()");
$create->column('updated_at')->type('timestamp')->default("current_timestamp() ON UPDATE current_timestamp()");
$create->save();
$create->primary('id');
$create->autoIncrement('id');
$create->addKey('users_categories', "id_user", "users", "id");
*/