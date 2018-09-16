<?php

namespace App\Infrastructure\Persistence\Doctrine\Repositories;

use App\Domain\Entities\MatrixLog;
use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * Class MatrixLogRepository
 * @package App\Infrastructure\Persistence\Doctrine\Repositories
 */
class MatrixLogRepository extends DocumentRepository
{
    /**
     * @param MatrixLog $matrixLog
     */
    public function add(MatrixLog $matrixLog)
    {
        $this->dm->persist($matrixLog);
        $this->dm->flush();
    }
}