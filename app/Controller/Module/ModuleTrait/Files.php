<?php

namespace Source\Controller\Module\ModuleTrait;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

trait Files
{
    /**
     * @return string[]
     */
    protected function files($path, $searchFolder = 'Example'): array
    {
        $directoryIterator = new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS);
        $iterator = new RecursiveIteratorIterator($directoryIterator, RecursiveIteratorIterator::SELF_FIRST);

        foreach ($iterator as $file) {
            if ($file->isFile() && str_contains($file->getPath(), $searchFolder)) {
                $relativePath = substr($file->getPathname(), strlen($path));
                $this->files[] = ltrim($relativePath, '/');
            }
        }
        return $this->files;
    }

    protected function determineFileType(string $file): string
    {
        if (str_contains($file, "Database")) {
            return 'database';
        }
        if (str_contains($file, "Model")) {
            return 'model';
        }
        if (str_contains($file, "Public") && !str_contains($file, "menu")) {
            return 'public';
        }
        return 'unknown';
    }
}