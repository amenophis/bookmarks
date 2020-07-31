<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Clock;
use Cake\Chronos\Chronos;

class ChronosClock implements Clock
{
    public function now(): \DateTimeInterface
    {
        return Chronos::now();
    }
}
