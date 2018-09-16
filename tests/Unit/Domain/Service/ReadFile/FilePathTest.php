<?php

namespace Tests\Unit\Domain\Service\ReadFile;

use App\Domain\Service\ReadFile\FilePath;
use Tests\BaseTest;

/**
 * Class ReadFileTest
 * @package Tests\Unit\Domain\Service\ReadFile
 * @coversDefaultClass \App\Domain\Service\ReadFile\FilePath
 */
class FilePathTest extends BaseTest
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
     * @covers ::__construct()
     */
    public function create_file_path_with_valid_path_should_return_file_path_instance()
    {
        $filePath = new FilePath($this->logTestFilePath);

        $this->assertInstanceOf(FilePath::class, $filePath);
    }

    /**
     * @test
     * @covers ::__construct()
     * @expectedException \App\Domain\Exceptions\FileNotFoundException
     */
    public function create_file_path_with_invalid_path_should_throw_exception()
    {
        new FilePath('ivalid/path');
    }
}