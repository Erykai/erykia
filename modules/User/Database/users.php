<?php
use Source\Core\Migration;
$migration = new Migration();
$migration->table(basename( __FILE__ , ".php"));
$migration->column("id")->type("int(11)")->default();
$migration->column("id_users")->type("int(11)")->default();
$migration->column("dad")->type("varchar(255)")->default();
$migration->column("name")->type("varchar(255)")->default();
$migration->column("email")->type("varchar(255)")->default();
$migration->column("password")->type("varchar(255)")->default();
$migration->column("level")->type("int(11)")->default(10);
$migration->column("cover")->type("varchar(255)")->default()->null();
$migration->column("trash")->type("boolean")->default();
$migration->column('created_at')->type('timestamp')->default("current_timestamp()");
$migration->column('updated_at')->type('timestamp')->default("current_timestamp() ON UPDATE current_timestamp()");
$migration->save();
$migration->primary('id');
$migration->autoIncrement('id');
$migration->addKey('users_users', "id_users", "users", "id");
/*####*/