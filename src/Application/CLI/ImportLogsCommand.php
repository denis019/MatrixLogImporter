<?php

namespace App\Application\CLI;

use App\Domain\Service\ReadFile\FilePath;
use App\Domain\Service\ReadFile\FileReader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportLogsCommand extends Command
{
    const BATCH_SIZE = 10000;

    protected function configure()
    {
        $this
            ->setName('app:import-logs')
            ->setDescription('Import logs.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //getLastMigrationNumber
        //createInProgressLogFile
        //fileRead
        //dataInsert

        $filePath = new FilePath(__DIR__ . '/../../../logPool/logs.log');
        $fileReader = new FileReader($filePath);

        $startLine = 0;

        while (($lines = $fileReader->read($startLine, 100)) != []) {
            $output->writeln(json_encode($lines));
            $startLine +=100;
        }
    }
}