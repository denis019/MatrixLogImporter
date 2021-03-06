<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Infrastructure\Persistence\Database;
use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\XmlDriver;

/**
 * Class Doctrine
 * @package App\Infrastructure\Persistence\Doctrine
 */
class Doctrine
{
    /**
     * @param string $env
     * @return DocumentManager
     */
    public static function createDocumentManager(string $env = 'prod'): DocumentManager
    {
        $driver = new XmlDriver([
            __DIR__ . '/Mapping'
        ]);

        $connection = new Connection("matrix_mongodb:27017");
        $config = new Configuration();

        $config->setProxyDir(__DIR__ . '/Proxies');
        $config->setProxyNamespace('Proxies');
        $config->setHydratorDir(__DIR__ . '/Hydrators');
        $config->setHydratorNamespace('Hydrators');
        $config->setMetadataDriverImpl($driver);
        $config->setDefaultDB(Database::ENV_DB[$env]);

        return DocumentManager::create($connection, $config);
    }
}