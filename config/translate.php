<?php
$lang = "pt-BR";
$str = [];
if(!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
    [$lang] = explode(",", $_SERVER['HTTP_ACCEPT_LANGUAGE']);
}
$configPath = dirname(__DIR__, 1) . '/translate';
require "$configPath/$lang.php";

$str = explode("&&&", $str);
function t($translate)
{
    /*
    global $str;
    $t["invalid email format"] = trim($str[0]);
    $t["invalid password format"] = trim($str[1]);
    $t["username is required"] = trim($str[2]);

    return $t[$translate];
*/
    return $translate;
}
