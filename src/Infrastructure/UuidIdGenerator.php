<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\IdGenerator;
use Ramsey\Uuid\Uuid;

class UuidIdGenerator implements IdGenerator
{
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
