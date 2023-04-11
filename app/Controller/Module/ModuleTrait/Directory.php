<?php

namespace Source\Controller\Module\ModuleTrait;

use RuntimeException;

trait Directory
{
    protected function createDir(): void
    {
        $component = ucfirst(strtolower($this->data->component));
        if (str_contains($this->data->component, "_")) {
            $component = explode("_", $component);
            $component = ucfirst(strtolower($component[0])) . ucfirst(strtolower($component[1]));
        }
        foreach ($this->files as $file) {
            // Remove o nome do arquivo para obter apenas o caminho do diretório
            $relativeDir = dirname($file);

            // Substitui 'Example' pelo nome do componente no caminho do diretório
            $relativeDir = str_replace('Example', $component, $relativeDir);

            // Cria o caminho absoluto do diretório
            $dirPath = MODULE_PATH . '/' . $relativeDir;

            // Verifica se o diretório existe e cria se necessário
            if (!file_exists($dirPath) && !mkdir($dirPath, 0755, true) && !is_dir($dirPath)) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $dirPath));
            }
        }
    }
}