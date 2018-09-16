<?php

namespace App\Domain\Service\ReadFile;

/**
 * Class ReadFile
 * @package App\Domain\Service\ReadFile
 */
class FileReader
{
    /** @var string */
    protected $filePath;

    /**
     * FileReader constructor.
     * @param FilePath $filePath
     */
    public function __construct(FilePath $filePath)
    {
        $this->filePath = $filePath->getPath();
    }

    /**
     * @param int $startLine
     * @param int|null $limit
     * @return array
     */
    public function read(int $startLine = 0, ?int $limit = null): array
    {
        if (is_null($limit)) {
            $fileIterator = $this->readFromStartLine($startLine);
        } else {
            $fileIterator = $this->readPartOfFile($startLine, $limit);
        }

        $content = [];
        foreach ($fileIterator as $iteration) {
            $content[] = $iteration;
        }

        return $content;
    }

    /**
     * @param int $startLine
     * @return \Generator
     */
    private function readFromStartLine(int $startLine)
    {
        $handle = fopen($this->filePath, "r");
        $lineNo = 0;

        while (!feof($handle)) {
            $lineNo++;

            if ($lineNo >= $startLine) {
                $line = trim(fgets($handle));
                // skip empty line
                if (!empty($line)) {
                    yield $line;
                }

            }
        }

        fclose($handle);
    }

    /**
     * @param int $startLine
     * @param int $limit
     * @return \Generator
     */
    private function readPartOfFile(int $startLine, int $limit)
    {
        $file = fopen($this->filePath, "r");
        $lineNo = 0;
        $readLines = 0;

        while (!feof($file)) {
            $lineNo++;

            if ($lineNo >= $startLine) {
                $line = trim(fgets($file));
                // skip empty line
                if (!empty($line)) {
                    yield $line;
                }
                $readLines++;
            } else {
                fgets($file);
            }

            if ($readLines >= $limit) {
                break;
            }
        }

        fclose($file);
    }
}