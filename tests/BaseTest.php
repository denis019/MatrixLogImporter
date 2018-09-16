<?php

namespace Tests;

use App\Application\Env;
use App\Domain\Entities\MatrixLog;
use App\Infrastructure\Persistence\Doctrine\Doctrine;
use PHPUnit\Framework\TestCase;
use Stubs\DocumentManager;

/**
 * Class BaseTest
 * @package Tests
 */
abstract class BaseTest extends TestCase
{
    /** @var DocumentManager */
    protected $dm;

    public function setUp()
    {
        parent::setUp();

        $this->dm = Doctrine::createDocumentManager(Env::TEST);
    }

    public function tearDown()
    {
        parent::tearDown();

        // clean test db
        $collection = $this->dm->getDocumentCollection(MatrixLog::class);
        $collection->remove([]);
    }

    /**
     * @return string
     */
    public function getTestLogFilePath(): string
    {
        return __DIR__ . '/log-pool/example-logs.log';
    }

    /**
     * @return string
     */
    public function getInProgressLogFileDestination(): string
    {
        return '/tmp/test-in-progress.log';
    }
}