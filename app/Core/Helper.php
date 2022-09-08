<?php

namespace Source\Core;

use PDO;
use PDOException;

class Helper
{
    public static $conn;

    public static function slug(string $title): string
    {
        $characters = array(
            'Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z', 'ž' => 'z', 'Č' => 'C', 'č' => 'c', 'Ć' => 'C', 'ć' => 'c',
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
            'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
            'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
            'à' => 'a', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
            'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
            'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b',
            'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r', '/' => '-', ' ' => '-'
        );
        $stripped = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $title);
        return strtolower(strtr($stripped, $characters));
    }

    public static function relationship(array $columns, string $table)
    {
        $return = [];
        foreach ($columns as $key => $column) {
            if (!isset($column->Field)) {
                $column->Field = $key;
            }
            if ((strpos($column->Field, "id_")) !== false) {
                $relationship = str_replace("id_", "", $column->Field);
                if ($table !== $relationship) {
                    $return['relationship'][$column->Field] = $relationship;
                }
            } else {
                $return['tables'][$column->Field] = $column->Field;
            }
        }
        return (object)$return;
    }

    public static function conn(string $dsn, string $host, string $base, string $username, string $password): PDO|string
    {
        if (empty(self::$conn)) {
            try {
                self::$conn = new PDO(
                    $dsn . ":host=" . $host . ";dbname=" . $base,
                    $username,
                    $password,
                    [
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
                    ]
                );
            } catch (PDOException $e) {
                self::$conn = $e->getMessage();
            }
        }
        return self::$conn;
    }

}