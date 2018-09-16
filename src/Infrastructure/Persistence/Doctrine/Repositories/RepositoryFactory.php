<?php

namespace App\Infrastructure\Persistence\Doctrine\Repositories;

use App\Domain\Entities\MatrixLog;
use App\Infrastructure\Persistence\Doctrine\Doctrine;

class RepositoryFactory
{
    /**
     * @return MatrixLogRepository
     */
    public static function createMatrixLogRepository(): MatrixLogRepository
    {
        $documentManager = Doctrine::createDocumentManager();
        return $documentManager->getRepository(MatrixLog::class);
    }
}