<?php

namespace App\Domain\Service\ParseMatrixLogData;

use App\Domain\Entities\MatrixLog;
use App\Domain\Exceptions\InvalidObjectTypeException;
use Tightenco\Collect\Support\Collection;

/**
 * Class MatrixLogCollection
 * @package App\Domain\Service\ParseMatrixLogData
 */
class MatrixLogCollection extends Collection
{
    /**
     * @inheritDoc
     */
    public function offsetSet($key, $value)
    {
        if (!is_a($value, MatrixLog::class)) {
            // @codeCoverageIgnoreStart
            throw new InvalidObjectTypeException('Invalid Matrix Log object');
            // @codeCoverageIgnoreEnd
        }
        parent::offsetSet($key, $value);
    }
}