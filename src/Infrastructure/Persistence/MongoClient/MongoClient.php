<?php

namespace App\Infrastructure\Persistence\MongoClient;

use App\Infrastructure\Exceptions\MongoDbConnectionException;
use App\Infrastructure\Exceptions\MongoDbSelectionException;
use MongoClient as BaseMongoClient;
use MongoConnectionException as BaseMongoConnectionException;

/**
 * Class MongoWrapper
 * @package App\Infrastructure\Persistence\MongoClient
 */
class MongoClient
{
    private static $connection;
    private static $instance;

    /**
     * MongoClient constructor.
     */
    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * @param null $database
     * @return BaseMongoClient|\MongoDB
     * @throws MongoDbConnectionException
     * @throws MongoDbSelectionException
     */
    public static function connect($database = null)
    {
        /*
         * Establish a new static object.
         */
        if (!isset(self::$instance)) {
            self::$instance = new MongoClient();
        }

        try {
            if (!isset(self::$connection)) {
                self::$connection = new BaseMongoClient('matrix_mongodb:27017');
            }
        } catch (BaseMongoConnectionException $e) {
            throw new MongoDbConnectionException();
        }

        /*
         * Make sure that a connection has been established.
         */
        if (!self::$connection->connected) {
            throw new MongoDbConnectionException("Error Connecting to DB.");
        }

        /*
         * Check to see if the database string is empty. If so return the object instance.
         */
        if (!empty($database) && is_string($database)) {
            $connectedDatabase = self::$connection->selectDB($database);
            if (isset($connectedDatabase)) {
                return $connectedDatabase;
            } else {
                throw new MongoDbSelectionException("Could not connect to desired database.");
            }
        }

        return self::$connection;
    }

}