<?php

namespace Source\Core;

use Exception;

class Upload
{
    private ?string $error;
    private string $mimeType;
    private array $types;

    /**
     * @throws Exception
     */
    public function image(object $files, string $name = null)
    {
        $types = [
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'png' => 'image/png',
            'svg' => 'image/svg+xml'
        ];
        return $this->exec($types, $files, $name);
    }

    /**
     * @return string|bool
     */
    public function error(): string|bool
    {
        if (!empty($this->error)) {
            return $this->error;
        }
        return false;
    }

    private function createDir(): string
    {
        $dir = UPLOAD_DIR;
        $this->mkdir($dir);
        $dir .= "/image";
        $this->mkdir($dir);
        $dir .= "/" . date('Y');
        $this->mkdir($dir);
        $dir .= "/" . date('m');
        $this->mkdir($dir);
        $dir .= "/" . date('d');
        $this->mkdir($dir);
        return $dir;
    }

    private function mkdir($dir)
    {
        if (!file_exists($dir)) {
            mkdir($dir, 0777);
        }
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     */
    public function setMimeType(string $mimeType): void
    {
        $this->mimeType = mime_content_type($mimeType);
    }

    /**
     * @return array
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    /**
     * @param array $types
     */
    public function setTypes(array $types): void
    {
        $this->types = $types;
    }

    public function exec(array$types, object $files, $name): array|bool|string
    {
        $this->setTypes($types);
        $this->setMimeType($files->tmp_name);
        if (!in_array($this->getMimeType(), $this->getTypes(), true)) {
            $this->error = 'allowed files: ' . implode(', ',array_keys($this->getTypes()));
            return false;
        }
        if (!$name) {
            $name = random_int(0, 1000) . time();
        }
        $ext = pathinfo($files->name, PATHINFO_EXTENSION);
        $dir = $this->createDir();
        $file = $dir . "/$name.$ext";

        if (file_exists($file) && is_file($file)) {
            $file = $dir . "/$name-".time().".$ext";
        }

        move_uploaded_file($files->tmp_name, $file);

        return str_replace(UPLOAD_DIR_OS, "", $file);
    }

}