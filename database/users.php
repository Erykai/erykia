<?php
/*
use Source\Core\CreateDatabase;
require "vendor/autoload.php";
$create = new CreateDatabase();
$create->table('users');
$create->column('id')->type('int(11)')->default();
$create->column('name')->type('varchar(255)')->default();
$create->column('password')->type('text')->default()->null();
$create->column('email')->type('varchar(255)')->default();
$create->column('level')->type('int(11)')->default();
$create->column('profile')->type('varchar(255)')->default()->null();
$create->column('cover')->type('varchar(255)')->default()->null();
$create->column('created_at')->type('timestamp')->default("current_timestamp()");
$create->column('updated_at')->type('timestamp')->default("current_timestamp() ON UPDATE current_timestamp()");
$create->save();
$create->primary('id');
$create->autoIncrement('id');
*/