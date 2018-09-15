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

    protected function setUp()
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
}