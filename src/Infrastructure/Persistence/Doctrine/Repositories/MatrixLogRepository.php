<?php

namespace App\Infrastructure\Persistence\Doctrine\Repositories;

use App\Domain\Entities\MatrixLog;
use Doctrine\ODM\MongoDB\Cursor;
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

    /**
     * @return MatrixLog|null
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function getLastLog(): ?MatrixLog
    {
        /** @var Cursor $cursor */
        $cursor = $this->createQueryBuilder()
            ->limit(1)
            ->sort([
                'lineNo' => 'desc'
            ])
            ->getQuery()
            ->execute();

        return $cursor->getSingleResult();
    }
}