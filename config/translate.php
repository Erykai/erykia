<?php
$lang = "pt-BR";
$str = [];
if(!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
    [$lang] = explode(",", $_SERVER['HTTP_ACCEPT_LANGUAGE']);
}
$configPathTranslate = dirname(__DIR__, 1) . '/translate';
require "$configPathTranslate/$lang.php";

$str = explode("&&&", $str);
function t($translate)
{
    //feito apenas para validar a nova entrada que sera objeto response
    if(!isset($translate->message)){
        $message = $translate;
        $translate = new stdClass();
        $translate->message = $message;
    }
    /*
    global $str;
    $t["invalid email format"] = trim($str[0]);
    $t["invalid password format"] = trim($str[1]);
    $t["username is required"] = trim($str[2]);

    return $t[$translate];
*/
    return $translate->message;
}
