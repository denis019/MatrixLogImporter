<?php

namespace App\Application\CLI;

use App\Application\DataTransferObject\LastLogStatistic;
use App\Domain\Service\CreateInProgressLogFile\InProgressLogFile;
use App\Domain\Service\ParseMatrixLogData\MatrixLogCollection;
use App\Domain\Service\ReadFile\FilePath;
use App\Domain\Service\ReadFile\FileReader;
use App\Infrastructure\Parser\MatrixLogParser;
use App\Infrastructure\Persistence\Doctrine\Repositories\MatrixLogRepository;
use App\Infrastructure\Persistence\Doctrine\Repositories\Repository;
use App\Infrastructure\Persistence\MongoClient\Repositories\MatrixLogRepository as MatrixLogBatchRepository;
use App\Infrastructure\Persistence\MongoClient\Repositories\Repository as BatchRepository;
use Exception;
use Kassner\LogParser\LogParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportLogsCommand extends Command
{
    const BATCH_SIZE = 10000;

    /** @var MatrixLogRepository */
    protected $matrixLogRepository;

    /** @var MatrixLogBatchRepository */
    protected $matrixLogBatchRepository;

    public function __construct(?string $name = null)
    {
        parent::__construct($name);

        $this->matrixLogRepository = Repository::getMatrixLogRepository();
        $this->matrixLogBatchRepository = BatchRepository::getMatrixLogRepository();
    }

    protected function configure()
    {
        $this
            ->setName('app:import-logs')
            ->addArgument('path', InputArgument::REQUIRED)
            ->setDescription('Import logs.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sourceFilePath = new FilePath($input->getArgument('path'));
        $imported = 0;

        do {
            $matrixLogCollection = $this->batchImport($sourceFilePath);

            $output->writeln('<info>Imported ' . $imported += $matrixLogCollection->count() . '</info>');
            $output->writeln('<info>MemoryUsage ' . $this->formatBytes(memory_get_usage()) . '</info>');
        } while ($matrixLogCollection->count() > 0);
    }

    protected function batchImport(FilePath $sourceFilePath): MatrixLogCollection
    {
        $lastLogStatistic = $this->getLastLogLineAdded();
        $matrixLogCollection = new MatrixLogCollection();

        $file = new InProgressLogFile(
            $sourceFilePath,
            $lastLogStatistic->lastLineNo + 1,
            $lastLogStatistic->lastLineNo + self::BATCH_SIZE
        );

        $file->create();

        try {
            $fileReader = new FileReader(new FilePath($file->getDestinationFilePath()));
            $content = $fileReader->read();
            $matrixLogParser = new MatrixLogParser(new LogParser());

            $matrixLogCollection = $matrixLogParser->parseArray(
                $content,
                $lastLogStatistic->lastMigrationNo + 1,
                $lastLogStatistic->lastLineNo
            );

            $this->matrixLogBatchRepository->batchInsert($matrixLogCollection->toArray());

        } catch (Exception $e) {
            // logException
        }

        $file->delete();

        return $matrixLogCollection;
    }

    /**
     * @return LastLogStatistic
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    private function getLastLogLineAdded(): LastLogStatistic
    {
        $lineNo = 0;
        $migrationNo = 0;

        $lastLog = $this->matrixLogRepository->getLastLog();

        if (!is_null($lastLog)) {
            $lineNo = $lastLog->getLineNo();
            $migrationNo = $lastLog->getMigrationNo();
        }

        $lastLogStatistic = new LastLogStatistic();
        $lastLogStatistic->lastLineNo = $lineNo;
        $lastLogStatistic->lastMigrationNo = $migrationNo;

        return $lastLogStatistic;
    }

    public function formatBytes($bytes, $precision = 2) {
        $units = array("b", "kb", "mb", "gb", "tb");

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . " " . $units[$pow];
    }
}