<?php

namespace App\Infrastructure\Persistence\Doctrine\Repositories;

use App\Domain\Entities\MatrixLog;
use App\Infrastructure\Persistence\Doctrine\Doctrine;

class Repository
{
    /**
     * @return MatrixLogRepository
     */
    public static function getMatrixLogRepository(): MatrixLogRepository
    {
        $documentManager = Doctrine::createDocumentManager();
        return $documentManager->getRepository(MatrixLog::class);
    }
}