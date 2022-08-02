<?php

/**
 * DATE
 */
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

/**
 * ERROR
 */
ini_set('display_errors', '1');
ini_set('display_startup_erros', '1');
error_reporting(E_ALL);

/**
 * AUTO INCLUDE
 */
$configPath = dirname(__DIR__, 1) . '/config';
foreach (scandir($configPath) as $configFile) {
    $file = $configPath . '/' . $configFile;
    if (is_file($file) && pathinfo($file, PATHINFO_EXTENSION) == 'php') {
        require_once $file;
    }
}