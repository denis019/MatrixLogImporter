<?php

namespace App\Domain\Service\ParseMatrixLogData;

use DateTime;

/**
 * Interface MatrixLogInterface
 * @package App\Domain\Service\ParseMatrixLogData
 */
interface MatrixLogInterface
{
    /**
     * @return int
     */
    public function getLineNo(): int;

    /**
     * @return string
     */
    public function getServiceName(): string;

    /**
     * @return DateTime|null
     */
    public function getDateTime(): ?DateTime;

    /**
     * @return string
     */
    public function getMethod(): string;

    /**
     * @return string
     */
    public function getUrl(): string;

    /**
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * @return int
     */
    public function getMigrationNo(): int;

    /**
     * @return string
     */
    public function getTime(): string;
}