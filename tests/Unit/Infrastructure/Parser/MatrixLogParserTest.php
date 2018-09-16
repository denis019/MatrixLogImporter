<?php

namespace Tests\Unit\Infrastructure\Parser;

use App\Domain\Entities\MatrixLog;
use App\Infrastructure\Parser\MatrixLogParser;
use Kassner\LogParser\LogParser;
use Tests\BaseTest;

/**
 * Class MatrixLogParserTest
 * @package Tests\Unit\Infrastructure\Parser
 * @coversDefaultClass \App\Infrastructure\Parser\MatrixLogParser
 */
class MatrixLogParserTest extends BaseTest
{

    /**
     * @test
     * @covers ::parse
     */
    public function parse_should_return_matrix_log_instance_with_correct_values()
    {
        $logParser = new LogParser();
        $matrixLogParser = new MatrixLogParser($logParser);

        $logLine = 'USER-SERVICE - - [17/Aug/2018:09:21:53 +0000] "POST /users HTTP/1.1" 201';

        $matrixLog = $matrixLogParser->parse($logLine);

        $this->assertInstanceOf(MatrixLog::class, $matrixLog);
        $this->assertEquals('USER-SERVICE', $matrixLog->getServiceName());
        $this->assertEquals(
            '17/Aug/2018:09:21:53 +0000',
            $matrixLog->getDateTime()->format('d/M/Y:H:i:s O')
        );
        $this->assertEquals('POST', $matrixLog->getMethod());
        $this->assertEquals('/users HTTP/1.1', $matrixLog->getUrl());
        $this->assertEquals('201', $matrixLog->getStatusCode());
    }

    /**
     * @test
     * @covers ::parse
     * @expectedException \App\Infrastructure\Exceptions\InvalidLogLineFormatException
     */
    public function parse_should_throw_exception_for_incorect_log_line()
    {
        $logParser = new LogParser();
        $matrixLogParser = new MatrixLogParser($logParser);

        $logLine = 'Incorect log line';

        $matrixLogParser->parse($logLine);
    }
}