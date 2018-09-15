<?php

namespace App\Domain\Service\ReadFile;

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
    }

    /**
     * @param string $path
     * @return bool
     */
    private function fileValidation(string $path): bool
    {
        return file_exists($path);
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}