<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

/**
 * Class BaseTest
 * @package Tests
 */
abstract class BaseTest extends TestCase
{
    /**
     * @return string
     */
    public function getTestLogFilePath(): string
    {
        return __DIR__ . '/logPool/example-logs.log';
    }
}