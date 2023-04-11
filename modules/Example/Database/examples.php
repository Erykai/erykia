<?php
use Source\Core\Migration;
$migration = new Migration();
$migration->table(basename( __FILE__ , ".php"));
$migration->column("id")->type("int(11)")->default();
$migration->column("id_examples")->type("int(11)")->default();
$migration->column("dad")->type("varchar(255)")->default();
/*###*/
$migration->column('created_at')->type('timestamp')->default("current_timestamp()");
$migration->column('updated_at')->type('timestamp')->default("current_timestamp() ON UPDATE current_timestamp()");
$migration->save();
$migration->primary('id');
$migration->autoIncrement('id');
$migration->addKey('examples_examples', "id_examples", "examples", "id");
/*####*/