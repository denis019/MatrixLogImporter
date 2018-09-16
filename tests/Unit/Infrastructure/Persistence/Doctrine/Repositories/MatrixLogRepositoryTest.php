<?php

namespace Tests\Unit\Infrastructure\Persistence\Doctrine\Repositories;

use App\Domain\Entities\MatrixLog;
use App\Infrastructure\Persistence\Doctrine\Repositories\MatrixLogRepository;
use Tests\BaseTest;

/**
 * Class MatrixLogRepositoryTest
 * @package Tests\Unit\Infrastructure\Persistence\Doctrine\Repositories
 * @coversDefaultClass \App\Infrastructure\Persistence\Doctrine\Repositories\MatrixLogRepository
 */
class MatrixLogRepositoryTest extends BaseTest
{
    /** @var MatrixLogRepository */
    protected $matrixLogRepository;

    public function setUp()
    {
        parent::setUp();
        $this->matrixLogRepository = $this->dm->getRepository(MatrixLog::class);
    }

    /**
     * @test
     * @covers ::add
     */
    public function add_should_persist_document()
    {
        $matrixLog = $this->createMatrixLog(1);
        $this->matrixLogRepository->add($matrixLog);
        $this->assertNotEmpty($matrixLog->getId());
    }

    /**
     * @test
     * @covers ::getLastLog
     */
    public function get_last_log()
    {
        $matrixLog = $this->createMatrixLog(1);
        $this->matrixLogRepository->add($matrixLog);

        $matrixLog = $this->createMatrixLog(2);
        $this->matrixLogRepository->add($matrixLog);

        $lastLog = $this->matrixLogRepository->getLastLog();

        $this->assertEquals(2, $lastLog->getLineNo());
    }

    /**
     * @param int $lineNo
     * @return MatrixLog
     */
    protected function createMatrixLog(int $lineNo): MatrixLog
    {
        $dateTime = new \DateTime('17/Aug/2018:09:22:54 +0000');

        /** @var MatrixLog $matrixLog */
        $matrixLog = new MatrixLog();
        $matrixLog->setServiceName('USER-SERVICE');
        $matrixLog->setLineNo($lineNo);
        $matrixLog->setDateTime($dateTime);
        $matrixLog->setMethod('POST');
        $matrixLog->setUrl('/users HTTP/1.1');
        $matrixLog->setStatusCode(201);

        return $matrixLog;
    }
}