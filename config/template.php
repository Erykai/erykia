<?php
$path = dirname(__DIR__, 1) . '/public';
define('TEMPLATE_PATH', $path);
const TEMPLATE_URL = 'https://lvh.me';
const TEMPLATE_CLIENT = 'client';
const TEMPLATE_DEFAULT = 'default';
const TEMPLATE_DASHBOARD = 'dashboard';
const TEMPLATE_REGEX_GLOBAL = '/{{([A-Z_]+)}}/';
const TEMPLATE_REGEX_TEXT = '/{{([a-zA-Zà-úÀ-Ú0-9|-|_|(|)|:?!.,\' ]+)}}/';
const TEMPLATE_REGEX_ROUTE = '/{{#(\/[a-z-]+[\/|[a-z])+#}}/';
const TEMPLATE_REGEX_DATA = '/{\{((?:\s*\$this->)?\$?[a-zA-Z_][a-zA-Z0-9_]*(?:->\$?[a-zA-Z_][a-zA-Z0-9_]*)*)\s*\}\}/';
