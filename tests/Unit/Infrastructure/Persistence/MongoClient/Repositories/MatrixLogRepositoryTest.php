<?php

namespace Tests\Unit\Infrastructure\Persistence\MongoClient\MongoClientTest;

use App\Application\Env;
use App\Infrastructure\Persistence\MongoClient\Repositories\MatrixLogRepository;
use Tests\BaseTest;

/**
 * Class MatrixLogRepositoryTest
 * @package Tests\Unit\Infrastructure\Persistence\MongoClient\MongoClientTest
 * @coversDefaultClass \App\Infrastructure\Persistence\MongoClient\Repositories\MatrixLogRepository
 */
class MatrixLogRepositoryTest extends BaseTest
{
    /** @var MatrixLogRepository */
    protected $matrixLogRepository;

    public function setUp()
    {
        parent::setUp();

        $this->matrixLogRepository = new MatrixLogRepository(Env::TEST);
    }

    /**
     * @test
     * @covers ::batchInsert
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

        $status = $this->matrixLogRepository->batchInsert($bulkData);

        $this->assertEquals(1, $status['ok']);
    }
}