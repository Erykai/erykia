<?php

namespace Source\Core;

class Env
{
    private static string $path;
    private static array $files;

    /**
     * @return void
     */
    public static function start(): void
    {
        self::setPath();
        self::setFiles();
        self::setEnv();
    }

    /**
     * @return string
     */
    private static function getPath(): string
    {
        return self::$path;
    }

    /**
     *  @return void
     */
    private static function setPath(): void
    {
        self::$path = dirname(__DIR__, 2);
    }

    /**
     * @return array
     */
    private static function getFiles(): array
    {
        return self::$files;
    }

    /**
     * @return void
     */
    private static function setFiles(): void
    {
        self::$files = file(self::getPath() ."/.env",FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }
    /**
     * @return void
     */
    private static function setEnv(): void
    {
        foreach (self::getFiles() as $env) {
            if(str_contains($env, '=')){
                [$key, $value] = explode('=', $env, 2);
                if(!array_key_exists($key, getenv())){
                    putenv(sprintf('%s=%s', $key, $value));
                    $_ENV[$key] = $value;
                }
            }
        }
    }
}