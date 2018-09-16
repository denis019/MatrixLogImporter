<?php

namespace App\Infrastructure\Parser;

use App\Domain\Entities\MatrixLog;
use App\Domain\Service\ParseMatrixLogData\MatrixLogCollection;
use App\Domain\Service\ParseMatrixLogData\MatrixLogInterface;
use App\Domain\Service\ParseMatrixLogData\ParseableInterface;
use App\Infrastructure\Exceptions\InvalidLogLineFormatException;
use Carbon\Carbon;
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

    /**
     * @param array $logLines
     * @param int $migration
     * @param int $lastLine
     * @return MatrixLogCollection
     * @throws InvalidLogLineFormatException
     */
    public function parseArray(array $logLines, int $migration, int $lastLine): MatrixLogCollection
    {
        $matrixLogCollection = new MatrixLogCollection();

        foreach ($logLines as $logLine) {
            $lastLine++;

            /** @var MatrixLog $matrixLog */
            $matrixLog = $this->parse($logLine);
            $matrixLog->setLineNo($lastLine);
            $matrixLog->setMigrationNo($migration);

            $matrixLogCollection->push($matrixLog);
        }

        return $matrixLogCollection;
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

        try {
            $dateTime = new \DateTime($parsedData->time);
        } catch (Exception $exception) {
            $dateTime = null;
        }

        /** @var MatrixLog $matrixLog */
        $matrixLog = new MatrixLog();
        $matrixLog->setServiceName($parsedData->host);
        $matrixLog->setTime($parsedData->time);
        $matrixLog->setDateTime($dateTime);
        $matrixLog->setMethod($parsedData->requestMethod);
        $matrixLog->setUrl($parsedData->URL);
        $matrixLog->setStatusCode($parsedData->status);

        return $matrixLog;
    }
}