<?php

namespace App\Infrastructure\Persistence\MongoClient\Repositories;

use App\Infrastructure\Persistence\Database;
use App\Infrastructure\Persistence\MongoClient\MongoClient;

/**
 * Class AbstractRepository
 * @package App\Infrastructure\Persistence\MongoClient\Repositories
 */
abstract class AbstractRepository
{
    protected $mongoDb;

    /**
     * AbstractRepository constructor.
     * @param string $env
     * @throws \App\Infrastructure\Exceptions\MongoDbConnectionException
     * @throws \App\Infrastructure\Exceptions\MongoDbSelectionException
     */
    public function __construct($env = 'prod')
    {
        $this->mongoDb = MongoClient::connect(Database::ENV_DB[$env]);
    }

    /**
     * @param array $content
     * @return mixed
     * @throws \MongoCursorException
     */
    public function batchInsert(array $content)
    {
        $collection = $this->mongoDb->{$this->getCollection()};
        return $collection->batchInsert($content);
    }

    /**
     * @return string
     */
    abstract function getCollection(): string;
}