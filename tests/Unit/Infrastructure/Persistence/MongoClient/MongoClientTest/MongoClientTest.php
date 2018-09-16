<?php

namespace Tests\Unit\Infrastructure\Persistence\MongoClient\MongoClientTest;

use App\Application\Env;
use App\Infrastructure\Persistence\Database;
use App\Infrastructure\Persistence\MongoClient\MongoClient;
use MongoDB;
use Tests\BaseTest;

/**
 * Class MongoClientTest
 * @package Tests\Unit\Infrastructure\Persistence\MongoClient\MongoClientTest
 */
class MongoClientTest extends BaseTest
{
    /** @var MongoDB */
    protected $mongoDb;

    public function setUp()
    {
        parent::setUp();

        $this->mongoDb = MongoClient::connect(Database::ENV_DB[Env::TEST]);
    }

    /**
     * @test
     */
    public function mongo_client()
    {
        $this->assertInstanceOf(MongoDB::class, $this->mongoDb);
    }

    /**
     * @test
     */
    public function batch_insert()
    {
        $bulkData = [
            [
                'lineNo' => 1,
                'migrationNo' => 1,
                'serviceName' => 'test',
                'dateTime' => new \DateTime(),
                'method' => 'POST',
                'url' => '/url',
                'statusCode' => 200,
            ],
            [
                'lineNo' => 2,
                'migrationNo' => 1,
                'serviceName' => 'test',
                'dateTime' => new \DateTime(),
                'method' => 'POST',
                'url' => '/url',
                'statusCode' => 200,
            ]
        ];

        $collection = $this->mongoDb->log;

        $status = $collection->batchInsert($bulkData);

        $this->assertEquals(1, $status['ok']);
    }
}