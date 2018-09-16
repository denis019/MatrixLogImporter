<?php

namespace App\Domain\Service\CreateInProgressLogFile;

use App\Domain\Service\ReadFile\FilePath;

/**
 * Class CreateInProgressLogFile
 * @package App\Domain\Service\CreateInProgressLogFile
 */
class CreateInProgressLogFile
{
    const DEFAULT_DESTINATION_FILE_PATH = '/tmp/in-progress.log';

    /** @var string */
    protected $sourceFilePath;

    /** @var string */
    protected $destinationFilePath;

    /** @var int */
    protected $startLine;

    /** @var int */
    protected $endLine;

    public function __construct(
        FilePath $sourceFilePath,
        int $startLine,
        int $endLine,
        string $destinationFilePath = null
    ) {
        $this->sourceFilePath = $sourceFilePath->getPath();
        $this->startLine = $startLine;
        $this->endLine = $endLine;

        if (is_null($destinationFilePath)) {
            $destinationFilePath = self::DEFAULT_DESTINATION_FILE_PATH;
        }

        $this->destinationFilePath = $destinationFilePath;
    }

    public function create(): void
    {
        $command = sprintf("sed -n '%s,%sp' %s > %s",
            $this->startLine,
            $this->endLine,
            $this->sourceFilePath,
            $this->destinationFilePath
        );

        shell_exec($command);
    }

    /**
     * @return string
     */
    public function getDestinationFilePath(): string
    {
        return $this->destinationFilePath;
    }
}