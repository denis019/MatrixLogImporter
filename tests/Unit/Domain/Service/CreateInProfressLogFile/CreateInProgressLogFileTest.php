<?php

namespace Tests\Unit\Domain\Service\CreateInProgressLogFile;

use App\Domain\Service\CreateInProgressLogFile\InProgressLogFile as DomainCreateInProgressLogFile;
use App\Domain\Service\ReadFile\FilePath;
use App\Domain\Service\ReadFile\FileReader;
use Tests\BaseTest;

/**
 * Class CreateInProgressLogFile
 * @package Tests\Unit\Domain\Service\CreateInProgressLogFile
 * @coversDefaultClass DomainCreateInProgressLogFile
 */
class CreateInProgressLogFileTest extends BaseTest
{
    /**
     * @test
     * @covers ::create
     */
    public function create_in_progress_log_file_should_create_correct_file()
    {
        $expected = [
            'USER-SERVICE - - [17/Aug/2018:09:29:13 +0000] "POST /users HTTP/1.1" 201',
            'USER-SERVICE - - [18/Aug/2018:09:30:54 +0000] "POST /users HTTP/1.1" 400'
        ];
        $sourceFilePath = new FilePath($this->getTestLogFilePath());

        $fileCreator = new DomainCreateInProgressLogFile(
            $sourceFilePath,
            14,
            15,
            $this->getInProgressLogFileDestination()
        );

        $fileCreator->create();

        $fileReader = new FileReader(new FilePath($this->getInProgressLogFileDestination()));
        $content = $fileReader->read();

        $this->assertEquals($expected, $content);
    }
}