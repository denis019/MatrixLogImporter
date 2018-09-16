<?php

namespace App\Infrastructure\Persistence\MongoClient\Repositories;

class Repository
{
    /**
     * @param string $env
     * @return MatrixLogRepository
     * @throws \App\Infrastructure\Exceptions\MongoDbConnectionException
     * @throws \App\Infrastructure\Exceptions\MongoDbSelectionException
     */
    public static function getMatrixLogRepository($env = 'prod'): MatrixLogRepository
    {
        return new MatrixLogRepository($env);
    }
}