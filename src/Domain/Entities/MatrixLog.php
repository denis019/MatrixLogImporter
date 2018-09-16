<?php

namespace App\Domain\Entities;

use App\Domain\Service\ParseMatrixLogData\MatrixLogInterface;
use DateTime;

/**
 * Class MatrixLog
 * @package App\Domain\Entities
 */
class MatrixLog implements MatrixLogInterface
{
    use OnPrePersistTrait;

    /** @var string */
    private $id;

    /** @var int */
    private $lineNo;

    /** @var string */
    private $serviceName;

    /** @var DateTime */
    private $dateTime;

    /** @var string */
    private $method;

    /** @var string */
    private $url;

    /** @var int */
    private $statusCode;

    /** @var DateTime */
    private $createdAt;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getLineNo(): int
    {
        return $this->lineNo;
    }

    /**
     * @param int $lineNo
     */
    public function setLineNo(int $lineNo): void
    {
        $this->lineNo = $lineNo;
    }

    /**
     * @return string
     */
    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    /**
     * @param string $serviceName
     */
    public function setServiceName(string $serviceName): void
    {
        $this->serviceName = $serviceName;
    }

    /**
     * @return DateTime
     */
    public function getDateTime(): DateTime
    {
        return $this->dateTime;
    }

    /**
     * @param DateTime $dateTime
     */
    public function setDateTime(DateTime $dateTime): void
    {
        $this->dateTime = $dateTime;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
}