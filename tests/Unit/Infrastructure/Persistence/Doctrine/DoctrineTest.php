<?php
namespace Tests\Unit\Infrastructure\Persistence\Doctrine;

use App\Domain\Entities\MatrixLog;
use App\Infrastructure\Persistence\Doctrine\Doctrine;
use Doctrine\ODM\MongoDB\DocumentManager;
use Tests\BaseTest;

/**
 * Class DoctrineTest
 * @package Tests\Unit\Infrastructure\Persistence\Doctrine
 * @coversDefaultClass \App\Infrastructure\Persistence\Doctrine\Doctrine
 */
class DoctrineTest extends BaseTest
{
    /**
     * @test
     * @covers ::make
     */
    public function doctrine_make_should_return_valid_document_manager()
    {
        $doctrine = Doctrine::make();
        $this->assertInstanceOf(DocumentManager::class, $doctrine);
    }

    /**
     * @test
     */
    public function doctrine_dm_should_persist_entity()
    {
        $dateTime = new \DateTime('17/Aug/2018:09:22:54 +0000');

        /** @var MatrixLog $matrixLog */
        $matrixLog = new MatrixLog();
        $matrixLog->setServiceName('USER-SERVICE');
        $matrixLog->setLineNo(1);
        $matrixLog->setDateTime($dateTime);
        $matrixLog->setMethod('POST');
        $matrixLog->setUrl('/users HTTP/1.1');
        $matrixLog->setStatusCode(201);

        $dm = Doctrine::make();

        $dm->persist($matrixLog);
        $dm->flush();

        $this->assertNotEmpty($matrixLog->getId());
    }
}