<?php

namespace App\Infrastructure\Parser;

use App\Domain\Service\ParseMatrixLogData\MatrixLog;
use App\Domain\Service\ParseMatrixLogData\MatrixLogInterface;
use App\Domain\Service\ParseMatrixLogData\ParseableInterface;
use App\Infrastructure\Exceptions\InvalidLogLineFormatException;
use Exception;
use Kassner\LogParser\LogParser;

/**
 * Class MatrixLogParser
 * @package App\Infrastructure\Parser\ParseMatrixLogData
 */
class MatrixLogParser implements ParseableInterface
{
    protected $parser;

    public function __construct(LogParser $logParser)
    {
        $this->parser = $logParser;
        $this->parser->setFormat($this->getFormat());
    }

    /**
     * @param string $logLine
     * @return MatrixLogInterface
     * @throws InvalidLogLineFormatException
     */
    public function parse(string $logLine): MatrixLogInterface
    {
        try {
            $parsedData = $this->parser->parse($logLine);
        } catch (Exception $exception) {
            throw new InvalidLogLineFormatException($exception->getMessage());
        }

        return $this->createMatrixLogFromParsedData($parsedData);
    }

    public function getFormat(): string
    {
        return '%h - - %t "%m %U" %>s';
    }

    /**
     * @param \stdClass $parsedData
     * @return MatrixLogInterface
     */
    private function createMatrixLogFromParsedData(\stdClass $parsedData): MatrixLogInterface
    {

        $dateTime = new \DateTime($parsedData->time);

        /** @var MatrixLog $matrixLog */
        $matrixLog = new MatrixLog(
            $parsedData->host,
            $dateTime,
            $parsedData->requestMethod,
            $parsedData->URL,
            $parsedData->status
        );

        return $matrixLog;
    }
}