<?php
use Source\Core\Migration;
$migration = new Migration();
$table = basename( __FILE__ , ".php");
$migration->table($table);
$migration->column("id")->type("int(11)")->default();
$migration->column("id_user")->type("int(11)")->default();
$migration->column("dad")->type("varchar(255)")->default();
//migrationRequire
$migration->column('created_at')->type('timestamp')->default("current_timestamp()");
$migration->column('updated_at')->type('timestamp')->default("current_timestamp() ON UPDATE current_timestamp()");
$migration->save();
$migration->primary('id');
$migration->autoIncrement('id');
$migration->addKey('users_'.$table, "id_user", "users", "id");