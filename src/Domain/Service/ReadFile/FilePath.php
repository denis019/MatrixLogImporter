<?php

namespace App\Domain\Service\ReadFile;

use App\Domain\Exceptions\FileNotFoundException;

/**
 * Class FilePath
 * @package App\Domain\Service\ReadFile
 */
class FilePath
{
    /** @var string */
    private $path;

    public function __construct(string $path)
    {
        $this->fileValidation($path);

        $this->path = $path;
    }

    /**
     * @param string $path
     * @throws \Exception
     */
    private function fileValidation(string $path)
    {
        if (!file_exists($path)) {
            throw new FileNotFoundException();
        }
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}