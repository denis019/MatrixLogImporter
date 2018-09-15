<?php

namespace App\Domain\Service\ParseMatrixLogData;

use DateTime;

/**
 * Class MatrixLog
 * @package App\Domain\Service\ParseLogData
 */
class MatrixLog implements MatrixLogInterface
{
    /** @var string */
    protected $serviceName;

    /** @var DateTime */
    protected $dateTime;

    /** @var string */
    protected $method;

    /** @var string */
    protected $url;

    /** @var int */
    protected $statusCode;

    public function __construct(
        string $serviceName,
        DateTime $dateTime,
        string $method,
        string $url,
        int $statusCode
    ) {
        $this->serviceName = $serviceName;
        $this->dateTime = $dateTime;
        $this->method = $method;
        $this->url = $url;
        $this->statusCode = $statusCode;
    }

    /**
     * @return string
     */
    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    /**
     * @return DateTime
     */
    public function getDateTime(): DateTime
    {
        return $this->dateTime;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}