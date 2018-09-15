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
     * @return string
     */
    public function getServiceName(): string;

    /**
     * @return DateTime
     */
    public function getDateTime(): DateTime;

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
}