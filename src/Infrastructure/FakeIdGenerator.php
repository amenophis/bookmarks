<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\IdGenerator;

class FakeIdGenerator implements IdGenerator
{
    private static string $uuid;

    public static function setUuid(string $uuid): void
    {
        self::$uuid = $uuid;
    }

    public function generate(): string
    {
        return self::$uuid;
    }
}
