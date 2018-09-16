<?php

namespace App\Domain\Entities;

use App\Domain\Service\ParseMatrixLogData\MatrixLogInterface;
use DateTime;
use MongoDate;
use Tightenco\Collect\Contracts\Support\Arrayable;

/**
 * Class MatrixLog
 * @package App\Domain\Entities
 */
class MatrixLog implements MatrixLogInterface, Arrayable
{

    /** @var string */
    private $id;

    /** @var int */
    private $lineNo;

    /** @var int */
    private $migrationNo;

    /** @var string */
    private $serviceName;

    /** @var string */
    private $time;

    /** @var DateTime|null */
    private $dateTime;

    /** @var string */
    private $method;

    /** @var string */
    private $url;

    /** @var int */
    private $statusCode;

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
     * @return DateTime|null
     */
    public function getDateTime(): ?DateTime
    {
        return $this->dateTime;
    }

    /**
     * @param DateTime|null $dateTime
     * @return MongoDate|null
     */
    public function dateTimeToMongoDateTime(?DateTime $dateTime): ?MongoDate
    {
        return is_null($dateTime) ? null : new MongoDate($dateTime->getTimestamp());
    }

    /**
     * @param DateTime|null $dateTime
     */
    public function setDateTime(?DateTime $dateTime): void
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
     * @return int
     */
    public function getMigrationNo(): int
    {
        return $this->migrationNo;
    }

    /**
     * @param int $migrationNo
     */
    public function setMigrationNo(int $migrationNo): void
    {
        $this->migrationNo = $migrationNo;
    }

    /**
     * @return string
     */
    public function getTime(): string
    {
        return $this->time;
    }

    /**
     * @param string $time
     */
    public function setTime(string $time): void
    {
        $this->time = $time;
    }

    public function toArray()
    {
        return [
            'lineNo' => $this->getLineNo(),
            'migrationNo' => $this->getMigrationNo(),
            'serviceName' => $this->getServiceName(),
            'time' => $this->getTime(),
            'dateTime' => $this->dateTimeToMongoDateTime($this->getDateTime()),
            'method' => $this->getMethod(),
            'url' => $this->getUrl(),
            'statusCode' => $this->getStatusCode(),
        ];
    }
}