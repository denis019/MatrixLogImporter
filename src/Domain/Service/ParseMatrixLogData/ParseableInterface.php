<?php

namespace App\Domain\Service\ParseMatrixLogData;

/**
 * Interface ParseableInterface
 * @package App\Domain\Service\ParseMatrixLogData
 */
Interface ParseableInterface
{
    public function parse(string $logLine): MatrixLogInterface;

    public function parseArray(array $logLines, int $migration, int $lastLine): MatrixLogCollection;

    public function getFormat(): string;
}