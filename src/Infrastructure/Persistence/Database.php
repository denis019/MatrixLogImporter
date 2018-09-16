<?php

namespace App\Infrastructure\Persistence;

use App\Application\Env;

class Database
{
    const ENV_DB = [
        Env::TEST => 'test-matrix-log',
        Env::PROD => 'matrix-log'
    ];
}