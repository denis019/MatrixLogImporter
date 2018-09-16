<?php

namespace Tests\Unit\Domain\Service\ReadFile;

use App\Domain\Service\ReadFile\FilePath;
use App\Domain\Service\ReadFile\FileReader;
use Tests\BaseTest;

/**
 * Class ReadFileTest
 * @package Tests\Unit\Domain\Service\ReadFile
 * @coversDefaultClass \App\Domain\Service\ReadFile\FileReader
 */
class FileReaderTest extends BaseTest
{
    /** @var string */
    protected $logTestFilePath;

    public function setUp()
    {
        parent::setUp();

        $this->logTestFilePath = $this->getTestLogFilePath();
    }

    /**
     * @test
     * @covers ::read
     */
    public function read_entire_file_should_return_correct_line_count()
    {
        $filePath = new FilePath($this->logTestFilePath);
        $fileReader = new FileReader($filePath);
        $this->assertEquals(count($fileReader->read()), 20);
    }

    /**
     * @test
     * @covers ::read
     */
    public function read_file_with_limit_should_return_correct_line_count()
    {
        $filePath = new FilePath($this->logTestFilePath);
        $fileReader = new FileReader($filePath);

        $this->assertEquals(count($fileReader->read(0, 10)), 10);
    }

    /**
     * @test
     * @covers ::read
     */
    public function read_file_with_start_line_limit_should_start_reading_from_the_correct_line()
    {
        $filePath = new FilePath($this->logTestFilePath);
        $fileReader = new FileReader($filePath);
        $lines = $fileReader->read(2, 1);

        $this->assertEquals(count($lines), 1);
        $this->assertEquals(
            'USER-SERVICE - - [17/Aug/2018:09:21:54 +0000] "POST /users HTTP/1.1" 400',
            $lines[0]
        );
    }
}