<?php

namespace Source\Core;


use Composer\Package\Loader\ValidatingArrayLoader;

class Controller
{
    use Auth;

    private object $data;
    private string $upload;
    private ?object $query = null;
    private ?object $file = null;
    private ?string $error = null;
    protected object $session;

    public function __construct()
    {
        $this->setData();
        $this->session = new Session();
    }

    /**
     * @return object
     */
    protected function getData(): object
    {
        return $this->data;
    }

    private function setData(): void
    {
        $this->data = (object)filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (count(get_object_vars($this->data)) === 0) {
            try {
                $this->data = json_decode(file_get_contents('php://input'), false, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException $e) {
                $this->setError("json php://input {$e->getMessage()} - {$e->getFile()} - {$e->getLine()}");
            }
        }
    }

    /**
     * @return object|null
     */
    protected function getQuery(): ?object
    {
        return $this->query;
    }

    /**
     * @param array $data
     * @return bool
     */
    protected function setQuery(array $data): bool
    {
        if ($data['query']) {
            $this->query = (object)filter_var_array($data['query'], FILTER_DEFAULT);
            return true;
        }
        return false;
    }

    /**
     * @return object|null
     */
    protected function getFile(): ?object
    {
        return $this->file;
    }

    protected function setFile(): bool
    {
        if (!empty($_FILES)) {
            $upload = $_FILES;
            $count = count($upload);
            if ($count > 1) {
                foreach ($upload as $key => $file) {
                    $file['input'] = $key;
                    $files[] = (object)$file;
                }
                $files['count'] = $count;
                $this->file = (object)$files;
                return true;
            }
            $files = $_FILES;
            $files = $files[key($files)];
            $files['input'] = key($files);
            $files['count'] = $count;
            $this->file = (object)$files;
            return true;
        }
        return false;
    }

    protected function upload(string $attribute, string $type)
    {
        $upload = new Upload();
        $files = $this->getFile();
        $count = $files->count;
        unset($files->count);

        if ($count > 1) {
            foreach ($files as $file) {
                $name = Helper::slug(pathinfo($file->name, PATHINFO_FILENAME));
                $input = $file->input;
                $this->$attribute->$input = $upload->$type($file, $input . '-' . $name);
            }
        } else {
            $name = Helper::slug(pathinfo($files->name, PATHINFO_FILENAME));
            $input = $files->input;
            $this->$attribute->$input = $upload->$type($files, $input . '-' . $name);
        }
    }

    /**
     * @return string|null
     */
    protected function getError(): ?string
    {
        return $this->error;
    }

    /**
     * @param string|null $error
     */
    protected function setError(?string $error): void
    {
        $this->error = $error;
    }


}