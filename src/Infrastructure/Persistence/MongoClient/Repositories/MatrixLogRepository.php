<?php

namespace App\Infrastructure\Persistence\MongoClient\Repositories;

/**
 * Class MatrixLogRepository
 * @package App\Infrastructure\Persistence\MongoClient\Repositories
 */
class MatrixLogRepository extends AbstractRepository
{

    /**
     * @return string
     */
    function getCollection(): string
    {
        return 'log';
    }
}