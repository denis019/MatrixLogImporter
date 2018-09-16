<?php

namespace App\Domain\Entities;

use DateTime;

/**
 * Trait PrePersistCreatedAtTrait
 * @package App\Domain\Entities
 * @codeCoverageIgnore
 */
trait OnPrePersistTrait
{
    public function onPrePersist()
    {
        if ($this->createdAt == null) {
            $this->createdAt = new DateTime();
        }
    }
}