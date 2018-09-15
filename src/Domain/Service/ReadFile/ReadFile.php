<?php

namespace App\Domain\Service\ReadFile;

/**
 * Class ReadFile
 * @package App\Domain\Service\ReadFile
 */
class ReadFile
{
    /** @var FilePath */
    protected $filePath;

    public function __construct(FilePath $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @param int $fromLine
     * @param int|null $limit
     * @return array
     */
    public function read(int $fromLine = 0, ?int $limit = null): array
    {
        return [];
    }
}